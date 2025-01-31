@switch($status)
    @case('running')
        <div class="site-badge success">{{ __('Running') }}</div>
        @break
    @case('due')
        <div class="site-badge danger">{{ __('Due') }}</div>
        @break
    @case('closed')
        <div class="site-badge pending">{{ __('Closed') }}</div>
        @break
    @case('completed')
        <div class="site-badge success">{{ __('Completed') }}</div>
        @break
@endswitch
