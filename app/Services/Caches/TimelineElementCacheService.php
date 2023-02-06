<?php

namespace App\Services\Caches;

use App\Models\TimelineElement;
use Illuminate\Support\Facades\Cache;
use App\Facades\CampaignLocalization;
use Illuminate\Support\Facades\DB;

class TimelineElementCacheService extends BaseCache
{
    /**
     * @return array
     */
    public function iconSuggestion(): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $key = $this->iconSuggestionKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $default = [
            'ra ra-tower',
            'fa-solid fa-home',
            'ra ra-capitol',
            'ra ra-skull',
            'fa-solid fa-coins',
            'ra ra-beer',
            'fa-solid fa-map-marker-alt',
            'fa-solid fa-thumbtack',
            'ra ra-wooden-sign',
            'fa-solid fa-map-pin'
        ];

        $data = TimelineElement::leftJoin('timelines as t', 't.id', 'timeline_elements.timeline_id')
            ->where('t.campaign_id', $campaign->id)
            ->select(DB::raw('icon, MAX(timeline_elements.created_at) as cmat'))
            ->groupBy('icon')
            ->whereNotNull('icon')
            ->orderBy('cmat', 'DESC')
            ->take(10)
            ->pluck('icon')
            ->all();

        foreach ($default as $key => $value) {
            if (!in_array($value, $data)) {
                $data[] = $value;
            }
        }

        $data = array_slice($data, 0, 10);

        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearSuggestion(): self
    {
        $this->forget(
            $this->iconSuggestionKey()
        );
        return $this;
    }


    /**
     * Type suggestion cache key
     * @return string
     */
    protected function iconSuggestionKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_timeline_element_suggestions';
    }
}
