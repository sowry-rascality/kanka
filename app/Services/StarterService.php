<?php

namespace App\Services;

use App\Enums\Widget;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Location;
use App\Traits\UserAware;
use Exception;

class StarterService
{
    use UserAware;

    protected Campaign $campaign;


    /**
     * @return Campaign
     */
    public function createCampaign(): Campaign
    {
        $data = [
            'name' => __('starter.campaign.name', ['user' => $this->user->name]),
            'entry' => '',
            'excerpt' => '',
            'ui_settings' => ['nested' => true]
        ];
        /** @var Campaign $campaign */
        $campaign = Campaign::create($data);
        $this->user->setCurrentCampaign($campaign);

        try {
            $this->generateBoilerplate($campaign);
        } catch (Exception $e) {
            // Don't block the user if the boilerplate crashes
        }

        return $campaign;
    }

    /**
     * @param Campaign $campaign
     */
    public function generateBoilerplate(Campaign $campaign)
    {
        CampaignLocalization::forceCampaign($campaign);
        EntityCache::campaign($campaign);
        CharacterCache::campaign($campaign);
        $this->campaign = $campaign;

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.kingdom1.name'),
            'type' => __('starter.kingdom1.type'),
            'entry' => '<p>' . __('starter.kingdom1.description') . '</p>',
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => __('starter.kingdom2.name'),
            'type' => __('starter.kingdom2.type'),
            'parent_location_id' => $kingdom->id,
            'entry' => '<p>' . __('starter.kingdom2.description') . '</p>',
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $city->save();

        // Generate characters
        $james = new Character([
            'name' => __('starter.character1.name'),
            'title' => __('starter.character1.title'),
            'age' => '43',
            'sex' => __('starter.character1.sex'),
            'entry' => '<p>' . __('starter.character1.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $campaign->id,
            'fears' => __('starter.character1.fears'),
            'traits' => __('starter.character1.traits'),
            'is_private' => false,
        ]);
        $james->save();

        $irwie = new Character([
            'name' => __('starter.character2.name'),
            'title' => __('starter.character2.title'),
            'age' => '31',
            'sex' => __('starter.character2.sex'),
            'entry' => '<p>' . __('starter.character2.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $campaign->id,
            'fears' => __('starter.character2.fears'),
            'traits' => __('starter.character2.traits'),
            'is_private' => false,
        ]);
        $irwie->save();

        $this->dashboard();
    }

    /**
     * Setup the new campaign's dashboard
     */
    protected function dashboard()
    {
        // Note for the dashboard
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Welcome->value,
            'width' => 6, // half
            'position' => 1,
        ]);
        $widget->save();

        // Recent widget
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Recent->value,
            'width' => 0,
            'position' => 2,
        ]);
        $widget->save();
    }
}
