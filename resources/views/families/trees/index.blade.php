@extends('layouts.app', [
    'title' => __('families/trees.title', ['name' => $family->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $family,
])

@section('content')

    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $family,
            'breadcrumb' => [
                Breadcrumb::entity($family->entity)->list(),
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'tree', 'model' => $family])

        <div class="entity-main-block">

            @if (!$campaign->superboosted())
                <x-cta :campaign="$campaign" superboost="1">
                    <p>{{ __('families/trees.pitch') }}</p>
                </x-cta>
            @else
                @if ($mode === 'pixi')
                <div class="family-tree-setup overflow-auto"
                    data-api="{{ route('families.family-tree.api', [$campaign, $family]) }}"
                    data-save="{{ route('families.family-tree.api-save', [$campaign, $family]) }}"
                    data-entity="{{ route('families.family-tree.entity-api', [$campaign, 0]) }}"
                >
                </div>
                @else
                <div id="family-tree">
                    <family-tree
                        api="{{ route('families.family-tree.api', [$campaign, $family]) }}"
                        save_api="{{ route('families.family-tree.api-save', [$campaign, $family]) }}"
                        entity_api="{{ route('families.family-tree.entity-api', [$campaign, 0]) }}"
                        search_api="{{ route('search.entities-with-relations', [$campaign, 'only' => config('entities.ids.character')]) }}"
                    >
                    </family-tree>
                </div>
                @endif
            @endif
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/family-tree-vue.js')
@endsection
@section('styles')
    @parent
    @vite('resources/sass/family-tree.scss')
@endsection

