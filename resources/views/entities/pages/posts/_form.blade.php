<?php
/**
 * @var \App\Models\EntityNotePermission $perm
 */
$permissions = [
    0 => __('crud.view'),
    1 => __('crud.edit'),
    2 => __('crud.permissions.actions.bulk.deny')
];
$currentCampaign = \App\Facades\CampaignLocalization::getCampaign();
$defaultCollapsed = null;
if (!isset($model) && !empty($currentCampaign->ui_settings['post_collapsed'])) {
    $defaultCollapsed = 1;
}

$options = $entity->postPositionOptions(!empty($model->position) ? $model->position : null);
$last = array_key_last($options);

$bragiName = $entity->isCharacter() ? $entity->name : null;
?>
<div class="nav-tabs-custom">
    <div class="pull-right">
        @include('entities.pages.posts._save-options')
    </div>
    <ul class="nav-tabs">
        <li class="active">
            <a href="#form-entry" title="{{ __('crud.fields.entry') }}">
                {{ __('crud.fields.entry') }}
            </a>
        </li>
       @can('permission', $entity->child)
        <li class="">
            <a href="#form-permissions" title="{{ __('entities/notes.show.advanced') }}">
                {{ __('entities/notes.show.advanced') }}
            </a>
        </li>
       @endcan
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="form-entry">
            <x-grid>

                <div class="field-name col-span-2 required">
                    {!! Form::text('name', null, ['placeholder' => __('entities/notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'data-live-disabled' => '1', 'required', 'data-bragi-name' => $bragiName]) !!}
                </div>
                <div class="field-entry col-span-2">
                    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
                </div>

                <div class="field-location">
                    <input type="hidden" name="location_id" value="" />
                    @include('cruds.fields.location', ['from' => null])
                </div>

                @include('cruds.fields.visibility_id')

                <div class="field-position">
                    <label>{{ __('crud.fields.position') }}</label>
                    {!! Form::select('position', $options, (!empty($model->position) ? -9999 : $last), ['class' => 'form-control']) !!}
                </div>
                @php
                    $collapsedOptions = [
                        0 => __('entities/notes.collapsed.open'),
                        1 => __('entities/notes.collapsed.closed')
                    ];
                @endphp
                <div class="field-display">
                    <label>
                        {{ __('entities/notes.fields.display') }}
                    </label>
                    {!! Form::select('settings[collapsed]', $collapsedOptions, $defaultCollapsed, ['class' => 'form-control']) !!}
                </div>

                <div class="field-class">
                    <label for="config[class]">
                        {{ __('dashboard.widgets.fields.class') }}
                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('dashboard.widgets.helpers.class') }}"></i>
                    </label>
                    {!! Form::text('settings[class]', null, ['class' => 'form-control', 'id' => 'config[class]', 'disabled' => !$currentCampaign->boosted() ? 'disabled' : null]) !!}
                    <p class="help-block visible-xs visible-sm">
                        {{ __('dashboard.widgets.helpers.class') }}
                    </p>
                    @includeWhen(!$currentCampaign->boosted(), 'entities.pages.posts._boosted')
                </div>
            </x-grid>
        </div>

        @includeWhen(auth()->user()->can('permission', $entity->child), 'entities.pages.posts._permissions')
    </div>
</div>

{!! Form::hidden('entity_id', $entity->id) !!}
