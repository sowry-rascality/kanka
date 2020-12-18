<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\Identity;
use App\Facades\Mentions;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use Illuminate\Support\Str;

abstract class MiscObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     * @var EntityMappingService
     */
    protected $entityMappingService;

    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->slug = Str::slug($model->name, '');
        $model->campaign_id = CampaignLocalization::getCampaign()->id;
        //$model->name = strip_tags($model->name);

        // If we're from the "move" service, we can skip this part.
        // Or if we are deleting, we don't want to re-do the whole set foreign ids to null
        if (defined('MISCELLANY_SKIP_ENTITY_CREATION') ||
            request()->isMethod('delete') === true ||
            $model->savingObserver === false) {
            return;
        }

        $attributes = $model->getAttributes();
        if (array_key_exists('entry', $attributes)) {
            $model->entry = $this->purify(Mentions::codify($model->entry));
        }

        // Handle image. Let's use a service for this.
        ImageService::handle($model, $model->getTable());

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }

    /**
     * Event fired when the model is created from the crud controller
     * @param MiscModel $model
     */
    public function crudSaved(MiscModel $model)
    {
        // Characters use this for personality traits
    }

    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        // If we're from the "move" service, we can skip this part.
        if ($model->savingObserver === false && $model->forceSavedObserver === false) {
            return;
        }

        // Whenever an misc model is saved, we need to make sure it has an associated entity with it.
        // If none exists, we need to create one. Otherwise, we need to update it.
        $entity = $model->entity;
        if (empty($entity)) {
            $entity = new Entity([
                'entity_id' => $model->id,
                'campaign_id' => $model->campaign_id
            ]);
        }
        $entity->is_private = $model->is_private;
        $entity->name = $model->name;
        $entity->type = $model->getEntityType();

        // Once saved, refresh the model so that we can call $model->entity
        if ($entity->save()) {
            // Take care of mentions for the entity.
            $this->syncMentions($model, $entity);
            $model->refresh();

            // Clear some cache
            EntityCache::clearSuggestion($model);
        }
    }

    public function created(MiscModel $model)
    {
        // If we're from the "move" service, we can skip this part.
        if ($model->savingObserver === false) {
            return;
        }

        // Created a new sub entity? Create the parent entity.
        $entity = $model->createEntity();

        // Copy attributes from source?
        if (request()->has('copy_source_notes') && request()->filled('copy_source_notes')) {
            $sourceId = request()->post('copy_source_id');
            /** @var Entity $source */
            $source = $source ?? Entity::findOrFail($sourceId);
            foreach ($source->notes as $note) {
                $note->copyTo($model->entity);
            }
        }
    }

    /**
     * @param MiscModel $model
     */
    public function deleted(MiscModel $model)
    {
        // Soft-delete the entity
        if ($model->entity) {
            $model->entity->delete();
        }

        // If soft deleting, don't really delete the image
        if ($model->trashed()) {
            return;
        }

        ImageService::cleanup($model);
    }

    /**
     * @param MiscModel $model
     */
    public function updated(MiscModel $model)
    {
        // We make an extra write to the db when doing this, but we always want the entity's updated_at to be in
        // sync with the model. For example if we just change the description, which is on the sub entity, we
        // still want the entity to be alerted. This is used for the recently modified dashboard widget.

        // Check if the entity exists, because it won't while moving an entity from one type to another.
        if ($model->entity) {
            $model->entity->touch();

            // Updated log. We do this here to have the dirty attributes of the child
            $log = new EntityLog();
            $log->entity_id = $model->entity->id;
            $log->created_by = auth()->user()->id;
            $log->impersonated_by = Identity::getImpersonatorId();
            $log->action = EntityLog::ACTION_UPDATE;
            // Full logs for superboosted campaigns. RIP sql server
            if ($model->campaign->boosted(true)) {
                $logs = [];
                $dirty = $model->getDirty();
                foreach ($dirty as $attribute => $value) {
                    if (in_array($attribute, $model->ignoredLogAttributes())) {
                        continue;
                    }
                    // We log the old value
                    $value = $model->getOriginal($attribute);
                    if (Str::endsWith($attribute, '_id')) {
                        // Foreign? Try and get the related model
                        $value = $this->getForeignOriginal($model, $attribute, $value);
                    }

                    $logs[$attribute] = $value;
                }
                $log->changes = $logs;
            }
            $log->save();
        }
    }

    /**
     * When saving an entity, we can to update our mentions if they have been changed
     * @param Entity $entity
     */
    protected function syncMentions(MiscModel $model, Entity $entity)
    {
        if (!$model->saveObserver) {
            return;
        }
        //$this->entityMappingService->verbose = true;
        // If the entity's entry has changed, we need to re-build it's map.
        if ($model->isDirty('entry')) {
            $this->entityMappingService->silent()->mapEntity($entity);
        }
    }

    /**
     * @param MiscModel $model
     * @param string $attribute
     * @param string $original
     * @return string
     */
    protected function getForeignOriginal(MiscModel $model, string $attribute, $original): string
    {
        if (empty($original)) {
            return '';
        }

        try {
            if ($attribute == 'parent_location_id') {
                $originalLocation = Location::where('id', $original)->first();
                if (!empty($originalLocation)) {
                    return (string) $originalLocation->name;
                }
                return '';
            }
            // Let's try based off of the attribute name
            $relationName = Str::before($attribute, '_id');
            $relationName = Str::camel($relationName);

            $relationClass = 'App\Models\\' . $relationName;
            /** @var MiscModel $relationModel */
            $relationModel = new $relationClass();
            $result = $relationModel->where('id', $original)->firstOrFail();
            return $result->name;
        }
        catch (\Exception $e) {
            //dd($e);
            return '';
        }

    }
}
