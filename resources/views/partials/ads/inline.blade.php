@ads('inline')
<div class="ads-space mb-5 hidden md:block">
    <div class="vm-placement" data-id="{{ config('tracking.venatus.entity') }}"></div>
</div>
<div class="ads-space mb-5 md:hidden">
    <div class="vm-placement" data-id="{{ config('tracking.venatus.inline') }}"></div>
</div>
@endads
