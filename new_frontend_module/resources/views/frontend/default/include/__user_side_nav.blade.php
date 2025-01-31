<aside class="user-sidebar">
    @php
        $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
        $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
    @endphp
    <div class="site-logo">
        <a href="{{route('home')}}" class="logo"><img src="{{ asset(setting('site_logo','global')) }}" style="height:{{ $height }};width:{{ $width }};max-width:none" alt="{{ auth()->user()->full_name }}"></a>
    </div>
    @php
        $dps_running = dpsRunning();
        $fdr_running = fdrRunning();
        $loan_running = loanRunning();
        $ticket_running = App\Models\Ticket::Opened()->count();
        $referral_counter = $user->referrals->count();
        $navigations = App\Models\UserNavigation::orderBy('position')->get();
    @endphp
    <nav class="user-nav">
        <ul>
            @foreach ($navigations as $navigation)
                @if ($navigation->type == 'dps' && setting('user_dps', 'permission') && auth()->user()->dps_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'fdr' && setting('user_fdr', 'permission') && auth()->user()->fdr_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'loan' && setting('user_loan', 'permission') && auth()->user()->loan_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'rewards' && setting('user_reward', 'permission') && auth()->user()->reward_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'portfolio' && setting('user_portfolio', 'permission') && auth()->user()->portfolio_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'referral' && setting('sign_up_referral', 'permission') && auth()->user()->referral_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'deposit' && setting('user_deposit', 'permission') && auth()->user()->deposit_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'withdraw' && setting('user_withdraw', 'permission') && auth()->user()->withdraw_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'fund_transfer' && setting('transfer_status', 'permission') && auth()->user()->transfer_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'pay_bill' && setting('user_pay_bill', 'permission') && auth()->user()->pay_bill_status)
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @elseif ($navigation->type == 'dashboard' || $navigation->type == 'support' || $navigation->type == 'transactions' || $navigation->type == 'settings' || $navigation->type == 'logout')
                    @include('frontend::include.__menu-item',['navigation' => $navigation])
                @endif
            @endforeach
        </ul>
    </nav>
</aside>
