@if($status == 1)
    <div class="site-badge success">{{ __('Active') }}</div>
@elseif($status == 2)
    <div class="site-badge bg-warning">{{ __('Closed') }}</div>
@else
    <div class="site-badge danger">{{ __('Deactivated') }}</div>
@endif
