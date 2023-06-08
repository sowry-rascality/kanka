<?php
/**
* @var \App\Models\Timeline $timeline
* @var \App\Models\TimelineEra $model
*/
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines/eras.create.title', ['name' => $timeline->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('timelines'), 'label' => \App\Facades\Module::plural(config('entities.ids.timeline'), __('entities.timelines'))],
        ['url' => $timeline->entity->url(), 'label' => $timeline->name],
        __('timelines/eras.create.title')
    ]
])
@inject('campaignService', 'App\Services\CampaignService')
@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['timelines.timeline_eras.store', $timeline],
        'method' => 'POST',
        'id' => 'timeline-era-form',
        'class' => 'ajax-subform',
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <x-box>

        @include('timelines.eras._form', ['model' => null])

        <x-box.footer>
            @include('partials.footer_cancel', ['ajax' => null])
            <div class="form-era pull-right">
                <div class="submit-group">
                    <button class="btn btn-success">{{ __('crud.save') }}</button>
                </div>
                <div class="submit-animation" style="display: none;">
                    <button class="btn btn-success" disabled><i class="fa-solid fa-spinner fa-spin"></i></button>
                </div>
            </div>
        </x-box.footer>
    </x-box>
    @if (!empty($from))
        <input type="hidden" name="from" value="{{ $from }}">
    @endif
    {!! Form::close() !!}
@endsection
