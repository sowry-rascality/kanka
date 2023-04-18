@if (config('entities.file_upload'))
<li class="list-group-item">
        <b>{{ trans('crud.fields.files') }}
        @can('update', $model)
            <i class="fa-solid fa-cloud-upload-alt pull-right entity-file-ui" data-url="{{ route('entities.entity_assets.index', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('crud.files.actions.manage') }}"></i>
        @endif
        </b>

    <div class="entity-file-list" data-url="{{ route('entities.files', [$model->entity]) }}">
        @include('entities.components._files', ['entity' => $model->entity])
    </div>
</li>


@section('scripts')
    @parent
@endsection
@endif
