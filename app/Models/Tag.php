<?php

namespace App\Models;

use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\TagScopes;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Tag
 * @package App\Models
 *
 * @property string $name
 * @property string $type
 * @property string $colour
 * @property int|null $tag_id
 * @property Tag|null $tag
 * @property Tag[]|Collection $tags
 * @property bool $is_auto_applied
 * @property bool $is_hidden
 *
 * @property Entity[]|Collection $entities
 */
class Tag extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use SoftDeletes;
    use SortableTrait;
    use TagScopes;

    /**
     * Entity type
     */
    protected string $entityType = 'tag';

    protected $explicitFilters = ['tag_id'];

    protected array $sortable = [
        'name',
        'tag.name',
        'type',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'tag.name',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'colour',
        'entry',
        'tag_id',
        'campaign_id',
        'is_private',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'tag_id',
    ];

    protected array $exportFields = [
        'base',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Parent
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id', 'id');
    }

    /**
     * Children
     */
    public function tags()
    {
        return $this->hasMany('App\Models\Tag', 'tag_id', 'id');
    }

    public function getParentKeyName(): string
    {
        return 'tag_id';
    }

    /**
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'tag' => function ($sub) {
                $sub->select('id', 'name');
            },
            'tag.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'tags' => function ($sub) {
                $sub->select('id', 'tag_id', 'name');
            },
            'descendants',
            'descendants.entities' => function ($sub) {
                $sub->select('entities.id', 'entities.name', 'entities.entity_id', 'entities.type_id');
            },
            'entities',
            'children' => function ($sub) {
                $sub->select('id', 'tag_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['tag_id', 'colour', 'is_auto_applied','is_hidden'];
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        /** @var Tag $child */
        foreach ($this->allChildren(true)->get() as $child) {
            $child->tags()->detach($this->id);
            //            if (!empty($child->child)) {
            //                $child->child->tag_id = null;
            //                $child->child->save();
            //            }
        }
        return parent::detach();
    }

    /**
     * Get all the children
     * @return Builder
     */
    public function allChildren(bool $withTags = false)
    {
        $children = [];
        foreach ($this->entities->pluck('id')->toArray() as $entity) {
            $children[] = $entity;
        }
        // @phpstan-ignore-next-line
        foreach ($this->descendants as $desc) {
            foreach ($desc->entities()->pluck('entities.id')->toArray() as $entity) {
                $children[] = $entity;
            }
        }

        if ($withTags) {
            return Entity::whereIn('id', $children);
        }
        return Entity::whereIn('id', $children)
            ->whereNotIn('type_id', [config('entities.ids.tag')]);
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Models\Entity',
            'entity_tags',
            'tag_id',
            'entity_id',
            'id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entityTags()
    {
        return $this->hasMany(EntityTag::class);
    }

    /**
     */
    public function menuItems(array $items = []): array
    {
        $count = $this->descendants->count();
        if ($count > 0) {
            $items['second']['tags'] = [
                'name' => Module::plural($this->entityTypeId(), 'entities.tags'),
                'route' => 'tags.tags',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.tag');
    }

    /**
     * Get the tag's colour class
     * @return string colour css class
     */
    public function colourClass(): string
    {
        if (!$this->hasColour()) {
            return '!border-0';
        }

        $mappings = config('colours.mappings');
        $colour = $this->colour;
        if (isset($mappings[$this->colour])) {
            $colour = $mappings[$this->colour];
        }
        $text = null;
        if (in_array($colour, ['navy', 'black'])) {
            $text = 'text-white';
        }

        return 'bg-' . $colour . ' color-palette color-tag !border-0 ' . $text . ' ';
    }

    /**
     */
    public function hasColour(): bool
    {
        return !empty($this->colour);
    }

    /**
     * Attach entities to the tag
     */
    public function attachEntities(array $entityIds): int
    {
        $data = $this->entities()->syncWithoutDetaching($entityIds);
        return count($data['attached']);
    }

    /**
     * Get the tag's html
     */
    public function html(): string
    {
        return '<span class="badge ' . ($this->hasColour() ? $this->colourClass() . 'py-1 rounded-sm' : 'color-tag rounded-sm px-2 py-1') . '">'
            . e($this->name) . '</span>';
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        return (bool) ($this->type || $this->colour);
    }

    /**
     * Determine if the model is a tag that has to be applied to all newly created entities
     */
    public function isAutoApplied(): bool
    {
        return (bool) $this->is_auto_applied;
    }

    /**
     * Determine if the model is a tag that is hidden
     */
    public function isHidden(): bool
    {
        return (bool) $this->is_hidden;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'colour',
            'is_auto_applied',
            'is_hidden',
        ];
    }
}
