@switch($status)
    @case(0)
        <div class="site-badge pending">{{ __('InActive') }}</div>
        @break
    @case(1)
        <div class="site-badge success">{{ __('Active') }}</div>
        @break
@endswitch
