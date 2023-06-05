<?php /** @var \App\Models\Entity $entity
 */?>
@extends('layouts.ajax', [
    'title' => __('entities/permissions.quick.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $model,
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <header>
        <h4 id="privacyDialogTitle">
            {!! __('entities/permissions.quick.title', ['name' => $entity->name]) !!}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
            <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
        </button>
    </header>
    <article>
        <div>
            <div class="form-inline">
                <div class="form-group">
                    <label for="privacy">{{ __('entities/permissions.quick.field') }}</label>
                    <select name="privacy" id="quick-privacy-select" class="form-control" data-url="{{ route('entities.quick-privacy.toggle', $entity) }}">
                        <option value="0">{{ __('entities/permissions.quick.options.visible') }}</option>
                        <option value="1" @if ($entity->is_private) selected="selected" @endif>{{ __('entities/permissions.quick.options.private') }}</option>
                    </select>
                </div>
            </div>

            <hr />

            <div>
                <strong>{{ __('entities/permissions.quick.viewable-by') }}</strong>
            </div>
            @if (!empty($visibility['roles']) || !empty($visibility['users']))
            <div class="mb-5 @if ($entity->is_private) line-through text-slate-400 @endif">
                @foreach ($visibility['roles'] as $element)<span class="mr-1"><i class="fa-solid fa-user-group" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
                @if (!empty($visibility['roles']))<br />@endif
                @foreach ($visibility['users'] as $element)<span class="mr-1"><i class="fa-solid fa-user" aria-hidden="true"></i> {!! $element !!}</span>@endforeach
            </div>
            @else
            <p class="help-block">
                {{ __('entities/permissions.quick.empty-permissions') }}
            </p>
            @endif

            <button class="btn2 btn-outline btn-sm btn-block btn-manage-perm" data-target="#entity-permissions-link">
                <i class="fa-solid fa-wrench" aria-hidden="true"></i> {{ __('entities/permissions.quick.manage') }}
            </button>
        </div>
    </article>
@endsection
