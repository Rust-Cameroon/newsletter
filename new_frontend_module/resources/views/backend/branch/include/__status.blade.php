@if($status == 1)
    <div class="site-badge success">{{ __('Active') }}</div>
@else
    <div class="site-badge danger">{{ __('DeActivated') }}</div>
@endif
