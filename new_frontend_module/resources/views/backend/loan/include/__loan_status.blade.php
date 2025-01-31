@switch($status)
    @case('reviewing')
        <div class="site-badge pending">{{ __('Reviewing') }}</div>
        @break
    @case('running')
        <div class="site-badge success">{{ __('Running') }}</div>
        @break
    @case('paid')
        <div class="site-badge success">{{ __('Paid') }}</div>
        @break
    @case('due')
        <div class="site-badge danger">{{ __('Due') }}</div>
        @break
    @case('rejected')
        <div class="site-badge danger">{{ __('Rejected') }}</div>
        @break
    @case('cancelled')
        <div class="site-badge danger">{{ __('Cancelled') }}</div>
        @break
@endswitch
