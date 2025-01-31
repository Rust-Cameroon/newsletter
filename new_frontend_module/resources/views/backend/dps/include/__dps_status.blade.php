@switch($status)
    @case('running')
        <div class="site-badge pending">{{ __('Running') }}</div>
        @break
    @case('mature')
        <div class="site-badge success">{{ __('Complete') }}</div>
        @break
    @case('due')
        <div class="site-badge danger">{{ __('Due') }}</div>
        @break
    @case('closed')
        <div class="site-badge danger">{{ __('Closed') }}</div>
        @break
@endswitch
