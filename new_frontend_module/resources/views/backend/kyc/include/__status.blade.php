@switch($kyc)
    @case(1)
        <div class="site-badge success">{{ __('Verified') }}</div>
        @break
    @case(2)
        <div class="site-badge pending">{{ __('Pending') }}</div>
        @break
    @case(3)
        <div class="site-badge danger">{{ __('Rejected') }}</div>
        @break
    @default
    <div class="site-badge danger">{{ __('Yet to submit') }}</div>

@endswitch
