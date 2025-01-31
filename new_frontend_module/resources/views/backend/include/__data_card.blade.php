@can('total-users')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="users"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['register_user'] }}</h4>
            <p>{{ __('Total Users') }}</p>
        </div>
        <a class="link" href="{{ route('admin.user.index') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('active-users')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="user-check"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['active_user'] }}</h4>
            <p>{{ __('Active Users') }}</p>
        </div>
        <a class="link" href="{{ route('admin.user.active') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('disabled-users')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="user-round-x"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['disabled_user'] }}</h4>
            <p>{{ __('Disabled Users') }}</p>
        </div>
        <a class="link" href="{{ route('admin.user.disabled') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('total-staff')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="user-cog"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['total_staff'] }}</h4>
            <p>{{ __('Total Staff') }}</p>
        </div>
        <a class="link" href="{{ route('admin.staff.index') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('total-deposits')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="wallet"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_deposit'] }}</span></h4>
            <p>{{ __('Total Deposits') }}</p>
        </div>
        <a class="link" href="{{ route('admin.deposit.history') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('total-withdraw')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="landmark"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_withdraw'] }}</span></h4>
            <p>{{ __('Total Withdraw') }}</p>
        </div>
        <a class="link" href="{{ route('admin.withdraw.history') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('total-referral')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="link"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['total_referral'] }}</h4>
            <p>{{ __('Total Referral') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-fund-transfer')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="send"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_send'] }}</span></h4>
            <p>{{ __('Total Fund Transfer') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-dps')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="archive"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_dps'] }}</span> </h4>
            <p>{{ __('Total DPS') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-fdr')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="book"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_fdr'] }}</span> </h4>
            <p>{{ __('Total FDR') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-loan')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="alert-triangle"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_loan'] }}</span> </h4>
            <p>{{ __('Total Loan') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-pay-bill')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="credit-card"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['total_bill'] }}</span> </h4>
            <p>{{ __('Total Pay Bill') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-reward-points')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="gift"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['points'] }}</h4>
            <p>{{ __('Total Reward Points') }}</p>
        </div>
    </div>
</div>
@endcan
@can('deposit-bonus')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="package-plus"></i>
        </div>
        <div class="content">
            <h4>{{ $currencySymbol }}<span class="count">{{ $data['deposit_bonus'] }}</span></h4>
            <p>{{ __('Deposit Bonus') }}</p>
        </div>
    </div>
</div>
@endcan
@can('total-automatic-gateway')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="webhook"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['total_gateway'] }}</h4>
            <p>{{ __('Total Automatic Gateways') }}</p>
        </div>
        <a class="link" href="{{ route('admin.gateway.automatic') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
@can('total-ticket')
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="data-card">
        <div class="icon">
            <i data-lucide="help-circle"></i>
        </div>
        <div class="content">
            <h4 class="count">{{ $data['total_ticket'] }}</h4>
            <p>{{ __('Total Ticket') }}</p>
        </div>
        <a class="link" href="{{ route('admin.ticket.index') }}"><i data-lucide="external-link"></i></a>
    </div>
</div>
@endcan
