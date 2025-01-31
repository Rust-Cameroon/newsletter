@if($kyc == 1)
    <div class="site-badge success">{{ __('Verified') }}</div>
@else
    <div class="site-badge pending">{{ __('Unverified') }}</div>
@endif
