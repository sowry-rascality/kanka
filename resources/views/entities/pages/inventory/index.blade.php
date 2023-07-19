<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-inventory'
])
@inject('campaignService', 'App\Services\CampaignService')



@section('entity-header-actions')
    @can('inventory', $entity->child)
        <div class="header-buttons inline-block flex flex-wrap gap-2 items-center justify-end">
            <a href="https://docs.kanka.io/en/latest/features/inventory.html" target="_blank" class="btn2 btn-ghost btn-sm">
                <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
            </a>
            @include('entities.pages.inventory._buttons')
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
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
                __('crud.tabs.inventory')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'inventory',
            'model' => $entity->child,
        ])
        <div class="entity-main-block">
        @include('entities.pages.inventory._table')
        </div>
    </div>

@endsection
