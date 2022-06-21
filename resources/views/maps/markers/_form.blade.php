<?php
/** @var \App\Models\MapMarker $model */

$iconOptions = [
    1 => __('maps/markers.icons.marker'),
    2 => __('maps/markers.icons.question'),
    3 => __('maps/markers.icons.exclamation'),
    4 => __('maps/markers.icons.entity'),
];

$sizeOptions = [
    1 => __('locations.map.points.sizes.tiny'),
    2 => __('locations.map.points.sizes.small'),
    3 => __('locations.map.points.sizes.standard'),
    4 => __('locations.map.points.sizes.large'),
    5 => __('locations.map.points.sizes.huge'),
    6 => __('locations.map.points.sizes.custom'),
];
?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li role="presentation" @if($activeTab == 1) class="active" @endif>
            <a href="#marker-pin" data-nohash="true" data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.marker') }}">
                <i class="fa-solid fa-2x fa-map-pin"></i><br />
                {{ __('maps/markers.tabs.marker') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 2) class="active" @endif>
            <a href="#marker-label" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.label') }}">
                <i class="fa-solid fa-2x fa-font"></i><br />
                {{ __('maps/markers.tabs.label') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 3) class="active" @endif>
            <a href="#marker-circle" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.circle') }}">
                <i class="fa-regular fa-2x fa-circle"></i><br />
                {{ __('maps/markers.tabs.circle') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.polygon') }}">
                <i class="fa-solid fa-2x fa-draw-polygon"></i><br />
                {{ __('maps/markers.tabs.polygon') }}
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane @if($activeTab == 1) active @endif" id="marker-pin">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="icon">{{ __('locations.map.points.fields.icon') }}</label>
                        {!! Form::select('icon', $iconOptions, \App\Facades\FormCopy::field('icon')->string(), ['class' => 'form-control', 'id' => 'icon']) !!}
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label>{{ __('maps/markers.fields.custom_icon') }}</label>
                            {!! Form::text('custom_icon', \App\Facades\FormCopy::field('custom_icon')->string(), ['class' => 'form-control', 'placeholder' => __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-sword"']), ($campaignService->campaign()->boosted() ? null : 'disabled')]) !!}
                            <p class="help-block">{!! __('maps/markers.helpers.custom_icon', ['rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>', 'fontawesome' => '<a href="https://fontawesome.com/search?m=free&s=solid" target="_blank">Font Awesome</a>']) !!}</p>
                        @if (!$campaignService->campaign()->boosted())
                            @subscriber()
                            <p class="help-block">
                                <i class="fa-solid fa-rocket" aria-hidden="true"></i> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaignService->campaign()])]) !!}
                            </p>
                            @else
                            <p class="help-block">
                                <i class="fa-solid fa-rocket" aria-hidden="true"></i> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
                            </p>
                            @endsubscriber
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <label for="pin_size">{{ __('maps/markers.fields.pin_size') }}</label><br />
                    {!! Form::number('pin_size', \App\Facades\FormCopy::field('pin_size')->string(), ['class' => 'form-control', 'maxlength' => 3, 'step' => 2, 'max' => 100, 'min' => 10, 'placeholder' => 40, 'id' => 'pin_size'] ) !!}
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label>{{ __('maps/markers.fields.font_colour') }}</label><br />
                        {!! Form::text('font_colour', \App\Facades\FormCopy::field('font_colour')->string(), ['class' => 'form-control spectrum', 'maxlength' => 6] ) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group checkbox">
                        {!! Form::hidden('is_draggable', 0) !!}
                        <label>{!! Form::checkbox('is_draggable', 1, (!empty($source) ? $source->is_draggable : null)) !!}
                            {{ __('maps/markers.fields.is_draggable') }}
                        </label>
                        <p class="help-block">{{ __('maps/markers.helpers.draggable') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane @if($activeTab == 2) active @endif" id="marker-label">
            <p class="help-block">{{ __('maps/markers.helpers.label') }}</p>
        </div>
        <div class="tab-pane @if($activeTab == 3) active @endif" id="marker-circle">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="size_id">{{ __('locations.map.points.fields.size') }}</label>
                        {!! Form::select('size_id', $sizeOptions, \App\Facades\FormCopy::field('size_id')->string(), ['class' => 'form-control', 'id' => 'size_id']) !!}
                    </div>
                </div>
                <div class="col-xs-6" style="">
                    <div class="form-group">
                        <label for="circle_radius">{{ __('maps/markers.fields.circle_radius') }}</label>
                        {!! Form::text('circle_radius', \App\Facades\FormCopy::field('circle_radius')->string(), ['class' => 'form-control map-marker-circle-radius', 'id' => 'circle_radius', 'style' => (!isset($model) || $model->shape_id != 6) ? 'display:none;' : '']) !!}
                        <p class="help-block map-marker-circle-helper">{{ __('maps/markers.helpers.custom_radius') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane @if($activeTab == 5) active @endif" id="marker-poly">
            <div class="form-group">
                <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                @if ($campaignService->campaign()->boosted())
                    @if(isset($model))
                        <p class="help-block">{{ __('maps/markers.helpers.polygon.' . ($activeTab == 5 ? 'edit' : 'new')) }}</p>
                    @endif
                    {!! Form::textarea('custom_shape', \App\Facades\FormCopy::field('custom_shape')->string(), ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('maps/markers.placeholders.custom_shape')]) !!}
                @else
                    @include('layouts.callouts.boost', ['texts' => [__('maps/markers.pitches.poly')], 'campaign' => $campaignService->campaign()])
                @endif
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label>{{ __('maps/markers.fields.polygon_style.stroke') }}</label><br />
                        {!! Form::text('polygon_style[stroke]', \App\Facades\FormCopy::field('polygon_style[stroke]')->string(), ['class' => 'form-control spectrum']) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label for="stroke-width">{{ __('maps/markers.fields.polygon_style.stroke-width') }}</label>
                        {!! Form::number('polygon_style[stroke-width]', \App\Facades\FormCopy::field('polygon_style[stroke-width]')->string(), ['class' => 'form-control', 'maxlength' => 2, 'step' => 1, 'max' => 99, 'min' => 0, 'id' => 'stroke-width']) !!}
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label for="stroke-opacity">{{ __('maps/markers.fields.polygon_style.stroke-opacity') }}</label>
                        {!! Form::number('polygon_style[stroke-opacity]', \App\Facades\FormCopy::field('polygon_style[stroke-opacity]')->string(), ['class' => 'form-control', 'maxlength' => 3, 'step' => 10, 'max' => 100, 'min' => 0, 'id' => 'stroke-opacity']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">{{ __('crud.fields.name') }}</label>
            {!! Form::text('name', \App\Facades\FormCopy::field('name')->string(), ['placeholder' => __('maps/markers.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'id' => 'name']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'entity_id',
                [
                    'preset' => (isset($model) && $model->entity ? $model->entity : \App\Facades\FormCopy::field('entity')->select()),
                    'class' => App\Models\Entity::class,
                    'labelKey' => 'crud.fields.entity',
                    'from' => null,
                    'searchRouteName' => 'search.entities-with-relations',
                    'placeholderKey' => 'crud.placeholders.entity',
                    'dropdownParent' => (isset($dropdownParent) ? $dropdownParent : null)
                ]
            ) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 mb-5" style="{{ (isset($model) && $model->hasEntry() ? 'display: none' : '') }}">
        <a href="#" class="map-marker-entry-click">{{ __('maps/markers.actions.entry') }}</a>
    </div>
    <div class="col-sm-12 map-marker-entry-entry" style="{{ (!isset($model) || !$model->hasEntry() ? 'display: none' : '') }}">
        <div class="form-group">
            <label>{{ __('crud.fields.entry') }}</label>
            {!! Form::textarea('entry', \App\Facades\FormCopy::field('entry')->string(), ['class' => 'form-control html-editor', 'id' => 'marker-entry', 'name' => 'entry']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="opacity">{{ __('maps/markers.fields.opacity') }}</label><br />
            {!! Form::number('opacity', (!empty($source) ? $source->opacity : (isset($model) ? $model->opacity : 100)), ['class' => 'form-control', 'maxlength' => 3, 'step' => 10, 'max' => 100, 'min' => 0, 'id' => 'opacity'] ) !!}
        </div>
    </div>
    <div class="col-sm-6" id="map-marker-bg-colour" @if((isset($model) && $model->isLabel()) || (isset($source) && $source->isLabel())) style="display: none;"@endif>
        <div class="form-group">
            <label>{{ __('locations.map.points.fields.colour') }}</label><br />
            {!! Form::text('colour', \App\Facades\FormCopy::field('colour')->string(), ['class' => 'form-control spectrum', 'maxlength' => 6] ) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="group_id">
                {{ __('maps/markers.fields.group') }}
            </label>
            {{ Form::select('group_id', $map->groupOptions(), \App\Facades\FormCopy::field('group_id')->string(), ['class' => 'form-control', 'id' => 'group_id']) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            @include('cruds.fields.visibility_id')
        </div>
    </div>
</div>

<div class="row @if (!$model && empty($source)) hidden @endif">
    <div class="col-xs-6">
        <div class="form-group">
            <label>{{ __('maps/markers.fields.latitude') }}</label>
            {!! Form::number('latitude', \App\Facades\FormCopy::field('latitude')->string(), ['class' => 'form-control', 'id' => 'marker-latitude', 'step' => 0.001]) !!}
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            <label>{{ __('maps/markers.fields.longitude') }}</label>
            {!! Form::number('longitude', \App\Facades\FormCopy::field('longitude')->string(), ['class' => 'form-control', 'id' => 'marker-longitude', 'step' => 0.001]) !!}
        </div>
    </div>
</div>

{!! Form::hidden('shape_id', (!isset($model) ? !empty($source) ? $source->shape_id : 1 : null)) !!}

@include('editors.editor')
