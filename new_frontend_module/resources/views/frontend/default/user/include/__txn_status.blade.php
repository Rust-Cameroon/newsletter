@switch($status)
    @case('pending')
        <div class="site-badge warnning">{{ __('Pending') }}</div>
        @break
    @case('success')
        <div class="site-badge success">{{ __('Success') }}</div>
        @break
    @case('failed')
        <div class="site-badge primary-bg">{{ __('canceled') }}</div>
        @break
@endswitch
