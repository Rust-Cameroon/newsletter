
<li
    @class([
        'active' => request()->url() == url($navigation->url),
        'logout' => $navigation->type == 'logout'
    ])
    >
    <a href="{{ url($navigation->url) }}">
        <i data-lucide="{{ $navigation->icon }}"></i>
        <span>{{ $navigation->name }}</span>
        @if($navigation->type == 'dps' && $dps_running > 0 )
        <b class="count-number">{{ $dps_running }}</b>
        @elseif($navigation->type == 'fdr' && $fdr_running > 0 )
        <b class="count-number">{{ $fdr_running }}</b>
        @elseif($navigation->type == 'loan' && $loan_running > 0 )
        <b class="count-number">{{ $loan_running }}</b>
        @elseif($navigation->type == 'referral' && $referral_counter > 0 )
        <b class="count-number">{{ $referral_counter }}</b>
        @elseif($navigation->type == 'support' && $ticket_running > 0 )
        <b class="count-number">{{ $ticket_running }}</b>
        @endif
    </a>
</li>
