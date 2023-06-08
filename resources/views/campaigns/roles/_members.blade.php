<?php
/**
 * @var \App\Models\CampaignRole $role
 * @var \App\Models\CampaignRoleUser[]|\Illuminate\Pagination\LengthAwarePaginator $members
 */
?>
<div class="flex gap-2 items-center mb-5">
    <h3 class="m-0 grow">{{ __('campaigns.roles.members') }}</h3>
    @can('user', $role)
        <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
           class="btn2 btn-primary btn-sm"
           data-toggle="ajax-modal" data-target="#entity-modal"
           data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
            <x-icon class="plus"></x-icon>
            {{ __('campaigns.roles.users.actions.add') }}
        </a>
    @endcan
</div>
@if ($members->isNotEmpty())
<x-box>
    @foreach ($members as $relation)
        <div class="flex items-center gap-2 mb-2">
            <div class="grow">
            {{ $relation->user->name }}
            @if (config('app.env') === 'local')
                <br />({{ $relation->user->email }})
            @endif
            </div>
            @can('delete', [$relation, $role])
                <a href="#" class="btn2 btn-error btn-outline btn-sm delete-confirm" data-toggle="modal" data-name="{{ __('campaigns.roles.users.actions.remove', ['user' => $relation->user->name, 'role' => $role->name]) }}"
                   data-target="#delete-confirm" data-delete-target="campaign-role-member-{{ $relation->id }}"
                   title="{{ __('crud.remove') }}">
                    <i class="fa-solid fa-user-slash" aria-hidden="true" data-toggle="tooltip" title="{{ __('campaigns.roles.users.actions.remove_user') }}"></i>
                </a>
            @endcan

        </div>
    @endforeach
    @if($members->hasPages())
        <div class="mt-5 text-right">
            {{ $members->links() }}
        </div>
    @endif
</x-box>
@else
    <x-alert type="info">
        <div class="mb-5">{{__('campaigns.roles.hints.empty_role')}}</div>

        @can('user', $role)
            <button href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}"
                    class="btn2 btn-primary btn-block"
                    data-toggle="ajax-modal" data-target="#entity-modal"
                    data-url="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}">
                <x-icon class="plus"></x-icon>
                {{ __('campaigns.roles.users.actions.add') }}
            </button>
        @endcan
    </x-alert>
@endif

@section('modals')
    @parent
    @foreach ($members as $relation)
        @can('delete', [$relation, $role])
        {!! Form::open([
                'method' => 'DELETE', 'route' => ['campaign_roles.campaign_role_users.destroy', 'campaign_role' => $role, 'campaign_role_user' => $relation->id],
                'style' => 'display:inline',
                'id' => 'campaign-role-member-' . $relation->id
            ]) !!}
        {!! Form::close() !!}
        @endcan
    @endforeach
@endsection
