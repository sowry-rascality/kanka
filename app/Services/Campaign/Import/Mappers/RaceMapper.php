<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Race;
use App\Traits\CampaignAware;

class RaceMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'race_id', 'created_at', 'updated_at'];

    protected string $className = Race::class;
    protected string $mappingName = 'races';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('race_id');
    }

    public function second(): void
    {
        $this->loadModel()
            ->pivot('pivotLocations', 'locations', 'location_id')
            ->saveModel()
            ->entitySecond()
        ;
    }

    public function prepare(): self
    {
        $this->campaign->races()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Race::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}
