<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Character;
use App\Models\CharacterOrganisation;
use App\Models\CharacterTrait;
use App\Traits\CampaignAware;

class CharacterMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'created_at', 'location_id', 'updated_at'];

    protected string $className = Character::class;
    protected string $mappingName = 'characters';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('character_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->pivot('characterFamilies', 'families', 'family_id')
            ->pivot('characterRaces', 'races', 'race_id')
            ->saveModel()
            ->traits()
            ->memberships()
            ->entitySecond();
    }

    public function prepare(): self
    {
        $this->campaign->characters()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        return $this;
    }

    protected function traits(): self
    {
        if (empty($this->data['characterTraits'])) {
            return $this;
        }
        foreach ($this->data['characterTraits'] as $data) {
            $trait = new CharacterTrait();
            $trait->character_id = $this->model->id;
            $trait->name = $data['name'];
            $trait->entry = $data['entry'];
            $trait->is_private = $data['is_private'];
            $trait->section_id = $data['section_id'];
            $trait->default_order = $data['default_order'];
            $trait->save();
        }
        return $this;
    }

    protected function memberships(): self
    {
        if (empty($this->data['organisationMemberships'])) {
            return $this;
        }
        $parents = [];
        foreach ($this->data['organisationMemberships'] as $data) {
            $member = new CharacterOrganisation();
            $member->character_id = $this->model->id;
            $member->organisation_id = ImportIdMapper::get('organisations', $data['organisation_id']);
            $member->role = $data['role'];
            $member->is_private = $data['is_private'];
            $member->pin_id = $data['pin_id'];
            $member->status_id = $data['status_id'];
            if (!empty($data['parent_id']) && isset($parents[$data['parent_id']])) {
                $member->parent_id = $parents[$data['parent_id']];
            }
            $member->save();

            $parents[$data['id']] = $member->id;
        }
        return $this;
    }
}
