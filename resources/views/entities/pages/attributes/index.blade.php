<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() || request()->filled('dashboard') ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-attributes'
])


@section('entity-header-actions')
    @can('attribute', [$entity->child, 'add'])
        <div class="header-buttons inline-block flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.attributes._buttons')
        </div>
    @endcan
@endsection


@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                Breadcrumb::entity($entity)->list(),
                __('crud.tabs.attributes')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'attributes',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            <x-box css="box-entity-attributes">
                @include('entities.pages.attributes.render')
            </x-box>
        </div>

        <input type="hidden" name="live-attribute-config" data-live="{{ route('entities.attributes.live.edit', [$campaign, $entity]) }}" />
    </div>
@endsection
