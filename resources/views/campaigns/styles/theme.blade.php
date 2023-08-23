<x-dialog.header>
    {!! __('campaigns/styles.theme.title') !!}
</x-dialog.header>
<article>
    {!! Form::model($campaign, ['route' => ['campaign-theme.save', $campaign], 'method' => 'POST', 'class' => 'w-full max-w-lg text-left']) !!}
    <div class="field-theme">
        <label>
            {{ __('campaigns.fields.theme') }}
            <x-helpers.tooltip :title="__('campaigns.helpers.theme')"/>
        </label>

        {!! Form::select(
            'theme_id',
            $themes,
            null,
            ['class' => 'form-control']
        ) !!}
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.theme') }}</p>
    </div>

    <x-dialog.footer>
        <button class="btn2 btn-primary">{{ __('crud.actions.apply') }}</button>
    </x-dialog.footer>
{!! Form::close() !!}
</article>
