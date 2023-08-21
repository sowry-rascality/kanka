<div class="entity-grid">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">

        @include('entities.components.posts', ['withEntry' => true])
        @include('families.panels._members')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>
