<div class="side-nav">
    <div class="side-nav-inside">
        <ul class="side-nav-menu">

            <li class="side-nav-item {{ isActive('admin.dashboard') }}">
                <a href="{{route('admin.dashboard')}}"><i data-lucide="layout-dashboard"></i><span>{{ __('Dashboard')
                        }}</span></a>
            </li>

            {{-- ************************************************************* Customer Management *********************************************************--}}
            @canany(['customer-list','customer-login','customer-mail-send','customer-basic-manage','customer-balance-add-or-subtract','customer-change-password','all-type-status'])
            <li class="side-nav-item category-title">
                <span>{{ __('Customer Management') }}</span>
            </li>
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.user*','admin.notification*']) }}">
                <a href="javascript:void(0);" class="dropdown-link">
                    <i data-lucide="users"></i><span>{{ __('Customers') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @canany(['customer-list','customer-login','customer-mail-send','customer-basic-manage','customer-balance-add-or-subtract','customer-change-password','all-type-status'])
                    <li class="{{ isActive('admin.user.index') }}">
                        <a href="{{route('admin.user.index')}}"><i data-lucide="users"></i>{{ __('All Customers') }}</a>
                    </li>
                    <li class="{{ isActive('admin.user.active') }}">
                        <a href="{{ route('admin.user.active') }}"><i data-lucide="user-check"></i>{{ __('Active
                            Customers') }}</a>
                    </li>
                    <li class="{{ isActive('admin.user.closed') }}">
                        <a href="{{ route('admin.user.closed') }}"><i data-lucide="x-circle"></i>{{ __('Closed
                            Customers') }}</a>
                    </li>
                    <li class="{{ isActive('admin.user.disabled') }}">
                        <a href="{{ route('admin.user.disabled') }}"><i data-lucide="user-x"></i>{{ __('Disabled
                            Customers') }}</a>
                    </li>
                    <li class="{{ isActive('admin.user.new') }}">
                        <a href="{{ route('admin.user.new') }}"><i data-lucide="user-plus"></i>{{
                            __('Add New Customer') }}</a>
                    </li>
                    @endcanany

                    <li class="{{ isActive('admin.notification.all') }}">
                        <a href="{{ route('admin.notification.all') }}"><i data-lucide="megaphone"></i>{{
                            __('Notifications') }}</a>
                    </li>
                    @can('customer-mail-send')
                    <li class="{{ isActive('admin.user.mail-send.all') }}">
                        <a href="{{ route('admin.user.mail-send.all') }}"><i data-lucide="send"></i>{{ __('Send Email to
                            all') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcanany

            @canany(['kyc-list','kyc-action','kyc-form-manage'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.kyc*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="check-square"></i><span>{{ __('KYC Management') }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @canany(['kyc-list','kyc-action'])
                    <li class="{{ isActive('admin.kyc.pending') }}">
                        <a href="{{ route('admin.kyc.pending') }}"><i data-lucide="airplay"></i>{{ __('Pending KYC')
                            }}</a>
                    </li>
                    <li class="{{ isActive('admin.kyc.rejected') }}">
                        <a href="{{ route('admin.kyc.rejected') }}"><i data-lucide="file-warning"></i>{{ __('Rejected
                            KYC') }}</a>
                    </li>
                    <li class="{{ isActive('admin.kyc.all') }}">
                        <a href="{{ route('admin.kyc.all') }}"><i data-lucide="contact"></i>{{ __('All KYC Logs') }}</a>
                    </li>
                    @endcanany
                    @can('kyc-form-manage')
                    <li class="{{ isActive('admin.kyc-form*') }}">
                        <a href="{{ route('admin.kyc-form.index') }}"><i data-lucide="check-square"></i>{{ __('KYC Options') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            {{-- ************************************************************* Staff Management *********************************************************--}}
            @canany(['role-list','role-create','role-edit','staff-list','staff-create','staff-edit'])
            <li class="side-nav-item category-title">
                <span>{{ __('Access Management') }}</span>
            </li>
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.roles*','admin.staff*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="users"></i><span>{{ __('System Access') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @canany(['role-list','role-create','role-edit'])
                    <li class="{{ isActive('admin.roles*') }}">
                        <a href="{{route('admin.roles.index')}}"><i data-lucide="contact"></i><span>{{ __('Manage Roles')
                                }}</span></a>
                    </li>
                    @endcanany
                    @canany(['staff-list','staff-create','staff-edit'])
                    <li class="{{ isActive('admin.staff*') }}">
                        <a href="{{route('admin.staff.index')}}"><i data-lucide="user-cog"></i><span>{{ __('Manage Staffs')
                                }}</span></a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany

            @if(setting('multi_branch'))
                {{-- ************************************************************* Branch Management *********************************************************--}}
                @canany(['branch-list','branch-create','branch-edit','branch-staff-list','branch-staff-create','branch-staff-edit'])
                <li class="side-nav-item category-title">
                    <span>{{ __('Manage Bank Branches') }}</span>
                </li>
                <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.branch*','admin.branch-staff*']) }}">
                    <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="split"></i><span>{{ __('Manage
                            Branches') }}</span>
                        <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                    <ul class="dropdown-items">
                        @canany(['branch-list','branch-create','branch-edit'])
                        <li class="side-nav-item {{ isActive('admin.branch*') }}">
                            <a href="{{route('admin.branch.index')}}"><i data-lucide="landmark"></i><span>{{ __('All Branch')
                                    }}</span></a>
                        </li>
                        @endcanany
                        @can(['branch-staff-list','branch-staff-create','branch-staff-edit'])
                        <li class="side-nav-item {{ isActive('admin.branch-staff*') }}">
                            <a href="{{route('admin.branch-staff.index')}}"><i data-lucide="user-cog"></i><span>{{ __('Branch
                                    Staff') }}</span></a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
            @endif

            {{-- ************************************************************* Transactions *********************************************************--}}
            @canany(['transaction-list','user-paybacks','bank-profit'])
            <li class="side-nav-item category-title">
                <span>{{ __('Transactions') }}</span>
            </li>
            @can('transaction-list')
            <li class="side-nav-item {{ isActive('admin.transactions') }}">
                <a href="{{route('admin.transactions')}}"><i data-lucide="cast"></i><span>{{ __('Transactions') }}</span></a>
            </li>
            @endcan
            @canany(['user-paybacks','bank-profit'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.paybacks', 'admin.bank.profit']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="dollar-sign"></i>
                    <span> {{ __('Profits') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>
                <ul class="dropdown-items">
                    @can('user-paybacks')
                    <li class="{{ isActive('admin.paybacks') }}">
                        <a href="{{route('admin.paybacks')}}"><i data-lucide="credit-card"></i><span>{{ __('User Paybacks') }}</span></a>
                    </li>
                    @endcan
                    @can('bank-profit')
                    <li class="{{ isActive('admin.bank.profit') }}">
                        <a href="{{route('admin.bank.profit')}}">
                            <i data-lucide="activity"></i><span>{{ __('Bank Profits') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['pending-transfers','rejected-transfers','all-transfers','allied-transfers','others-bank-transfers',
            'wire-transfer','others-bank-list'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.others-bank*', 'admin.wire.transfer*', 'admin.fund.transfer*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="send"></i><span>{{ __('Fund Transfer') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('pending-transfers')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.pending*') }}">
                        <a href="{{route('admin.fund.transfer.pending')}}"><i data-lucide="wallet-2"></i><span>{{ __('Pending Transfers') }}</span></a>
                    </li>
                    @endcan
                    @can('rejected-transfers')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.rejected*') }}">
                        <a href="{{route('admin.fund.transfer.rejected')}}"><i data-lucide="file-warning"></i><span>{{ __('Rejected Transfers') }}</span></a>
                    </li>
                    @endcan
                    @can('all-transfers')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.all*') }}">
                        <a href="{{route('admin.fund.transfer.all')}}"><i data-lucide="contact"></i><span>{{ __('All Transfers') }}</span></a>
                    </li>
                    @endcan
                    @can('allied-transfers')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.allied*') }}">
                        <a href="{{route('admin.fund.transfer.allied')}}"><i data-lucide="user-check"></i><span>{{ __('Allied Transfers') }}</span></a>
                    </li>
                    @endcan
                    @can('others-bank-transfers')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.other*') }}">
                        <a href="{{route('admin.fund.transfer.other')}}"><i data-lucide="user-minus"></i><span>{{ __('Other Bank Transfers') }}</span></a>
                    </li>
                    @endcan
                    @can('wire-transfer')
                    <li class="side-nav-item {{ isActive('admin.fund.transfer.wire*') }}">
                        <a href="{{route('admin.fund.transfer.wire')}}"><i data-lucide="settings-2"></i><span>{{ __('Wire Transfer') }}</span></a>
                    </li>
                    @endcan
                    @can('others-bank-list')
                    <li class="side-nav-item {{ isActive('admin.others-bank*') }}">
                        <a href="{{route('admin.others-bank.index')}}"><i data-lucide="landmark"></i><span>{{ __('Others Bank') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            {{-- ************************************************************* DPS *********************************************************--}}
            @canany(['dps-plan-list', 'dps-plan-create', 'dps-plan-edit', 'ongoing-dps','payable-dps','complete-dps','closed-dps','all-dps'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.dps*','admin.plan.dps*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="archive"></i><span>{{ __('DPS') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>

                <ul class="dropdown-items">
                    @can('ongoing-dps')
                    <li class="side-nav-item {{ isActive('admin.dps.ongoing*') }}">
                        <a href="{{route('admin.dps.ongoing')}}"><i data-lucide="user-check"></i><span>{{
                                __('Ongoing DPS') }}</span></a>
                    </li>
                    @endcan
                    @can('payable-dps')
                    <li class="side-nav-item {{ isActive('admin.dps.payable*') }}">
                        <a href="{{route('admin.dps.payable')}}"><i data-lucide="user-check"></i><span>{{
                                __('Payable DPS') }}</span></a>
                    </li>
                    @endcan
                    @can('complete-dps')
                    <li class="side-nav-item {{ isActive('admin.dps.complete*') }}">
                        <a href="{{route('admin.dps.complete')}}"><i data-lucide="user-check"></i><span>{{ __('Completed DPS') }}</span></a>
                    </li>
                    @endcan
                    @can('closed-dps')
                    <li class="side-nav-item {{ isActive('admin.dps.close*') }}">
                        <a href="{{route('admin.dps.close')}}"><i data-lucide="user-check"></i><span>{{ __('Closed DPS') }}</span></a>
                    </li>
                    @endcan
                    @can('all-dps')
                    <li class="side-nav-item {{ isActive('admin.dps.all*') }}">
                        <a href="{{route('admin.dps.all')}}"><i data-lucide="user-check"></i><span>{{ __('All DPS') }}</span></a>
                    </li>
                    @endcan
                    @canany(['dps-plan-list', 'dps-plan-create', 'dps-plan-edit'])
                    <li class="side-nav-item {{ isActive('admin.plan.dps*') }}">
                        <a href="{{route('admin.plan.dps.index')}}"><i data-lucide="airplay"></i><span>{{ __('DPS Plans') }}</span></a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany

            {{-- ************************************************************* FDR *********************************************************--}}
            @canany(['fdr-plan-list', 'fdr-plan-create', 'fdr-plan-edit', 'ongoing-fdr','closed-fdr','completed-fdr','all-fdr'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.fdr*', 'admin.plan.fdr*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="book"></i><span>{{ __('FDR') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('ongoing-fdr')
                    <li class="side-nav-item {{ isActive('admin.fdr.ongoing*') }}">
                        <a href="{{route('admin.fdr.ongoing')}}"><i data-lucide="user-check"></i><span>{{ __('Ongoing FDR') }}</span></a>
                    </li>
                    @endcan
                    @can('closed-fdr')
                    <li class="side-nav-item {{ isActive('admin.fdr.close*') }}">
                        <a href="{{route('admin.fdr.close')}}"><i data-lucide="user-check"></i><span>{{ __('Closed FDR') }}</span></a>
                    </li>
                    @endcan
                    @can('completed-fdr')
                    <li class="side-nav-item {{ isActive('admin.fdr.completed*') }}">
                        <a href="{{route('admin.fdr.completed')}}"><i data-lucide="user-check"></i><span>{{ __('Completed FDR') }}</span></a>
                    </li>
                    @endcan
                    @can('all-fdr')
                    <li class="side-nav-item {{ isActive('admin.fdr.all*') }}">
                        <a href="{{route('admin.fdr.all')}}"><i data-lucide="user-check"></i><span>{{ __('All FDR') }}</span></a>
                    </li>
                    @endcan
                    @canany(['fdr-plan-list', 'fdr-plan-create', 'fdr-plan-edit'])
                    <li class="side-nav-item {{ isActive('admin.plan.fdr*') }}">
                        <a href="{{route('admin.plan.fdr.index')}}"><i data-lucide="airplay"></i><span>{{ __('FDR Plans') }}</span></a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany

            {{-- ************************************************************* Loan *********************************************************--}}
            @canany(['pending-loan','running-loan','due-loan','paid-loan','rejected-loan','all-loan','loan-plan-list', 'loan-plan-create', 'loan-plan-edit','loan-plan-delete'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.plan.loan*','admin.loan*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="alert-triangle"></i><span>{{ __('Loan') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('pending-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.request*') }}">
                        <a href="{{route('admin.loan.request')}}"><i data-lucide="user-check"></i><span>{{ __('Loan Request') }}</span></a>
                    </li>
                    @endcan
                    @can('running-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.approved*') }}">
                        <a href="{{route('admin.loan.approved')}}"><i data-lucide="user-check"></i><span>{{ __('Approved Loan') }}</span></a>
                    </li>
                    @endcan
                    @can('due-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.payable*') }}">
                        <a href="{{route('admin.loan.payable')}}"><i data-lucide="user-check"></i><span>{{ __('Payable Installment') }}</span></a>
                    </li>
                    @endcan
                    @can('paid-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.completed*') }}">
                        <a href="{{route('admin.loan.completed')}}"><i data-lucide="user-check"></i><span>{{ __('Completed Loan') }}</span></a>
                    </li>
                    @endcan
                    @can('rejected-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.rejected*') }}">
                        <a href="{{route('admin.loan.rejected')}}"><i data-lucide="user-check"></i><span>{{ __('Rejected Loan') }}</span></a>
                    </li>
                    @endcan
                    @can('all-loan')
                    <li class="side-nav-item {{ isActive('admin.loan.all*') }}">
                        <a href="{{route('admin.loan.all')}}"><i data-lucide="user-check"></i><span>{{ __('All Loan') }}</span></a>
                    </li>
                    @endcan
                    @canany(['loan-plan-list', 'loan-plan-create', 'loan-plan-edit','loan-plan-delete'])
                    <li class="side-nav-item {{ isActive('admin.plan.loan*') }}">
                        <a href="{{route('admin.plan.loan.index')}}"><i data-lucide="airplay"></i><span>{{ __('Loan Plans') }}</span></a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcan
            @endcanany


            {{-- ************************************************************* Bill Management *********************************************************--}}

            @canany(['bill-service-import', 'bill-convert-rate', 'bill-service-list','all-bills', 'pending-bills', 'complete-bills', 'return-bills'])
                <li class="side-nav-item category-title">
                    <span>{{ __('Bill Management') }}</span>
                </li>

                <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.bill.import.services','admin.bill.convert.rate','admin.bill.service*']) }}">
                    <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="file"></i>
                        <span>{{ __('Bill Management') }}</span>
                        <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                    </a>
                    <ul class="dropdown-items">
                        @can('bill-service-import')
                            <li class="side-nav-item {{ isActive('admin.bill.import.services') }}">
                                <a href="{{ route('admin.bill.import.services') }}"><i data-lucide="download"></i><span>{{ __('Import Services') }}</span></a>
                            </li>
                        @endcan
                        @can('bill-convert-rate')
                            <li class="side-nav-item {{ isActive('admin.bill.convert.rate') }}">
                                <a href="{{ route('admin.bill.convert.rate') }}"><i data-lucide="git-pull-request"></i><span>{{ __('Convert Rate') }}</span></a>
                            </li>
                        @endcan
                        @can('bill-service-list')
                            <li class="side-nav-item {{ isActive('admin.bill.service*') }}">
                                <a href="{{ route('admin.bill.service.index') }}"><i data-lucide="list"></i><span>{{ __('Bill Service List') }}</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @canany(['all-bills', 'pending-bills', 'complete-bills', 'return-bills'])
                    <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.bill.history*']) }}">
                        <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="arrow-down-circle"></i><span>{{
                                __('Bill History') }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                        <ul class="dropdown-items">

                            @can('pending-bills')
                            <li class="{{ isActive('admin.bill.history.pending') }}"><a
                                    href="{{ route('admin.bill.history.pending') }}"><i data-lucide="workflow"></i>{{
                                    __('Pending Bill') }}</a></li>
                            @endcan

                            @can('complete-bills')
                            <li class="{{ isActive('admin.bill.history.complete') }}"><a
                                    href="{{route('admin.bill.history.complete')}}"><i data-lucide="compass"></i>{{
                                    __('Complete Bill') }}</a></li>
                            @endcan
                            @can('return-bills')
                            <li class="{{ isActive('admin.bill.history.returned') }}"><a
                                    href="{{route('admin.bill.history.returned')}}"><i data-lucide="compass"></i>{{
                                    __('Returned Bill') }}</a></li>
                            @endcan
                            @can('all-bills')
                            <li class="{{ isActive('admin.bill.history.all') }}"><a href="{{route('admin.bill.history.all')}}"><i
                                        data-lucide="compass"></i>{{
                                    __('All Bill') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

            @endcanany


            {{-- ************************************************************* Essentials *********************************************************--}}
            @canany(['automatic-gateway-manage','manual-gateway-manage','deposit-list','deposit-action',
            'withdraw-list','withdraw-method-manage','withdraw-action','referral-create',
            'manage-referral','referral-edit','referral-delete','manage-portfolio','portfolio-edit','portfolio-create','reward-earning-list','reward-earning-create','reward-earning-edit','reward-earning-delete','reward-redeem-list','reward-redeem-create','reward-redeem-edit','reward-redeem-delete'])

            <li class="side-nav-item category-title">
                <span>{{ __('Essentials') }}</span>
            </li>

            @canany(['automatic-gateway-manage','manual-gateway-manage','deposit-list','deposit-action'])
            @can('automatic-gateway-manage')
            <li class="side-nav-item {{ isActive('admin.gateway*') }}">
                <a href="{{ route('admin.gateway.automatic') }}"><i data-lucide="door-open"></i><span>{{ __('Automatic
                        Gateways') }}</span></a>
            </li>
            @endcan

            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.deposit*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="arrow-down-circle"></i><span>{{
                        __('Deposits') }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">

                    @can('automatic-gateway-manage')
                    <li class="{{ isActive('admin.deposit.method.list','auto') }}"><a
                            href="{{ route('admin.deposit.method.list','auto') }}"><i data-lucide="workflow"></i>{{
                            __('Automatic Methods') }}</a></li>
                    @endcan

                    @can('manual-gateway-manage')
                    <li class="{{ isActive('admin.deposit.method.list','manual') }}"><a
                            href="{{route('admin.deposit.method.list','manual')}}"><i data-lucide="compass"></i>{{
                            __('Manual Methods') }}</a></li>
                    @endcan

                    @canany(['deposit-list','deposit-action'])
                    <li class="{{ isActive('admin.deposit.manual.pending') }}"><a
                            href="{{ route('admin.deposit.manual.pending') }}"><i data-lucide="columns"></i>{{ __('Pending
                            Manual Deposits') }}</a></li>
                    <li class="{{ isActive('admin.deposit.history') }}"><a
                            href="{{ route('admin.deposit.history') }}"><i data-lucide="clipboard-check"></i>{{
                            __('Deposit History') }}</a></li>
                    @endcanany
                </ul>
            </li>
            @endcanany

            @canany(['withdraw-list','withdraw-method-manage','withdraw-action','withdraw-schedule'])
            <li class="side-nav-item side-nav-dropdown  {{ isActive(['admin.withdraw*']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="landmark"></i><span>{{ __('Withdraw')
                        }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('withdraw-method-manage')
                    <li class="{{ isActive('admin.withdraw.method.list','auto')  }}">
                        <a href="{{ route('admin.withdraw.method.list','auto') }}"><i data-lucide="workflow"></i>{{
                            __('Automatic Methods') }}</a>
                    </li>
                    <li class="{{ isActive('admin.withdraw.method.list','manual') }}">
                        <a href="{{route('admin.withdraw.method.list','manual')}}"><i data-lucide="compass"></i>{{
                            __('Manual Methods') }}</a>
                    </li>

                    @endcan
                    @canany(['withdraw-list','withdraw-action'])
                    <li class="{{ isActive('admin.withdraw.pending')  }}"><a
                            href="{{ route('admin.withdraw.pending') }}"><i data-lucide="wallet"></i>{{ __('Pending
                            Withdraws') }}</a></li>
                    @endcanany
                    @can('withdraw-schedule')
                    <li class="{{ isActive('admin.withdraw.schedule') }}"><a
                            href="{{ route('admin.withdraw.schedule') }}"><i data-lucide="alarm-clock"></i>{{ __('Withdraw
                            Schedule') }}</a></li>
                    @endcan
                    @can('withdraw-list')
                    <li class="{{ isActive('admin.withdraw.history') }}"><a
                            href="{{ route('admin.withdraw.history') }}"><i data-lucide="piggy-bank"></i>{{ __('Withdraw
                            History') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['referral-create','manage-referral','referral-edit','referral-delete'])
            <li class="side-nav-item {{ isActive('admin.referral.*') }}">
                <a href="{{ route('admin.referral.index') }}"><i data-lucide="align-end-horizontal"></i><span>{{ __('Referral') }}</span></a>
            </li>
            @endcanany

            @canany(['manage-portfolio','portfolio-create','portfolio-edit'])
            <li class="side-nav-item {{ isActive('admin.portfolio.*') }}">
                <a href="{{ route('admin.portfolio.index') }}"><i data-lucide="medal"></i><span>{{ __('Portfolios') }}</span></a>
            </li>
            @endcan

            @canany(['reward-earning-list','reward-earning-create','reward-earning-edit','reward-earning-delete','reward-redeem-list','reward-redeem-create','reward-redeem-edit','reward-redeem-delete'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.reward.point*']) }}">
                <a href="javascript:void(0);" class="dropdown-link">
                    <i data-lucide="medal"></i>
                    <span>{{ __('Manage Reward Point') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>

                <ul class="dropdown-items">

                    @canany(['reward-earning-list','reward-earning-create','reward-earning-edit','reward-earning-delete'])
                    <li class="{{ isActive('admin.reward.point.earnings*') }}">
                        <a href="{{ route('admin.reward.point.earnings.index') }}">
                            <i data-lucide="align-end-horizontal"></i>{{__('Reward Earnings') }}
                        </a>
                    </li>
                    @endcanany

                    @canany(['reward-redeem-list','reward-redeem-create','reward-redeem-edit','reward-redeem-delete'])
                    <li class="{{ isActive('admin.reward.point.redeem*') }}">
                        <a href="{{ route('admin.reward.point.redeem.index') }}">
                            <i data-lucide="align-end-horizontal"></i>{{__('Reward Redeems') }}
                        </a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcan

            @endcanany

            {{-- ************************************************************* Site Settings *********************************************************--}}
            @canany(['site-setting','email-setting','plugin-setting','page-manage','language-setting','sms-setting','push-notification-setting','notification-tune-setting'])
            <li class="side-nav-item category-title">
                <span>{{ __('Site Settings') }}</span>
            </li>
            @canany(['site-setting','email-setting','plugin-setting','page-manage','language-setting','sms-setting','push-notification-setting','notification-tune-setting'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.settings*','admin.language*','admin.page.setting']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="settings"></i>
                    <span>{{ __('Settings') }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('site-setting')
                    <li class="{{ isActive('admin.settings.site') }}">
                        <a href="{{route('admin.settings.site')}}"><i data-lucide="settings-2"></i>{{ __('Site Settings') }}</a>
                    </li>
                    @endcan
                    @can('email-setting')
                    <li class="{{ isActive('admin.settings.mail') }}">
                        <a href="{{ route('admin.settings.mail') }}"><i data-lucide="inbox"></i>{{ __('Email Settings') }}</a>
                    </li>
                    @endcan
                    @can('site-setting')
                    <li class="{{ isActive('admin.settings.seo.meta') }}">
                        <a href="{{route('admin.settings.seo.meta')}}"><i data-lucide="search-code"></i>{{ __('SEO Meta Settings') }}</a>
                    </li>
                    @endcan
                    @can('language-setting')
                    <li class="{{ isActive('admin.language*') }}">
                        <a href="{{ route('admin.language.index') }}"><i data-lucide="languages"></i><span>{{ __('Language Settings') }}</span></a>
                    </li>
                    @endcan
                    @can('page-manage')
                    <li class="side-nav-item {{ isActive('admin.page.setting') }}">
                        <a href="{{ route('admin.page.setting') }}"><i data-lucide="layout"></i><span>{{ __('Page Settings')
                                }}</span></a>
                    </li>
                    @endcan

                    @can('plugin-setting')
                    <li class="{{ isActive('admin.settings.plugin','system') }}">
                        <a href="{{ route('admin.settings.plugin','system') }}"><i data-lucide="toy-brick"></i>{{ __('Plugin Settings') }}</a>
                    </li>
                    @can('sms-setting')
                    <li class="{{ isActive('admin.settings.plugin','sms') }}">
                        <a href="{{ route('admin.settings.plugin','sms') }}"><i data-lucide="message-circle"></i>{{ __('SMS Settings') }}</a>
                    </li>
                    @endcan
                    @can('push-notification-setting')
                    <li class="{{ isActive('admin.settings.plugin','notification') }}">
                        <a href="{{ route('admin.settings.plugin','notification') }}"><i data-lucide="bell-ring"></i>{{ __('Push Notification') }}</a>
                    </li>
                    @endcan
                    @can('notification-tune-setting')
                    <li class="{{ isActive('admin.settings.notification.tune') }}">
                        <a href="{{ route('admin.settings.notification.tune') }}"><i data-lucide="volume-2"></i>{{ __('Notification Tune') }}</a>
                    </li>
                    @endcan
                    @endcan

                </ul>
            </li>
            @endcanany
            @endcanany


            {{-- ************************************************************* Site Essentials *********************************************************--}}
            @canany(['landing-page-manage','page-manage','footer-manage','navigation-manage','custom-css'])
            <li class="side-nav-item category-title">
                <span>{{ __('Appearance & Pages') }}</span>
            </li>

            @can('landing-page-manage')
            {{-- site theme Management--}}
            <li class="side-nav-item side-nav-dropdown  {{ isActive(['admin.theme*','admin.custom-css']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="palette"></i><span>{{ __('Appearance') }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    <li class="{{ isActive('admin.theme.site') }}">
                        <a href="{{ route('admin.theme.site') }}"><i data-lucide="roller-coaster"></i>{{ __('Site Theme')
                            }}</a>
                    </li>
                    <li class="{{ isActive('admin.theme.dynamic-landing') }}">
                        <a href="{{ route('admin.theme.dynamic-landing') }}"><i data-lucide="warehouse"></i>{{ __('Dynamic
                            Landing Theme') }}</a>
                    </li>

                    @can('custom-css')
                    <li class="side-nav-item {{ isActive('admin.custom-css') }}">
                        <a href="{{ route('admin.custom-css') }}"><i data-lucide="braces"></i><span>{{ __('Custom CSS') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            {{-- end site theme Management--}}

            <li class="side-nav-item side-nav-dropdown  {{ isActive(['admin.page.section.section*','admin.footer-content']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="home"></i><span>{{ __('Landing Page')
                        }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @can('page-manage')
                    <li class="side-nav-item {{ isActive('admin.page.section.management*') }}">
                        <a href="{{ route('admin.page.section.management') }}"><i data-lucide="list-end"></i><span>{{ __('Section Management') }}</span></a>
                    </li>
                    @endcan
                    @foreach($landingSections as $section)
                    <li class="@if(request()->is('admin/page/section/'.$section->code)) active @endif">
                        <a href="{{ route('admin.page.section.section',$section->code) }}"><i data-lucide="egg"></i>{{
                            $section->name }}</a>
                    </li>
                    @endforeach
                    @can('footer-manage')
                    <li class="side-nav-item {{ isActive('admin.footer-content') }}">
                        <a href="{{ route('admin.footer-content') }}"><i data-lucide="list-end"></i><span>{{ __('Footer Contents')
                                }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('page-manage')
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.page.edit*','admin.page.create']) }}">
                <a href="javascript:void(0);" class="dropdown-link"><i data-lucide="layout-grid"></i><span>{{ __('Pages')
                        }}</span><span class="right-arrow"><i data-lucide="chevron-down"></i></span></a>
                <ul class="dropdown-items">
                    @foreach($pages as $page)
                    <li class="@if(request()->is('admin/page/edit/'.$page->code)) active @endif">
                        <a href="{{ route('admin.page.edit',$page->code) }}"><i data-lucide="egg"></i>{{ $page->title
                            }}</a>
                    </li>
                    @endforeach
                    <li class="{{ isActive('admin.page.create') }}">
                        <a href="{{ route('admin.page.create') }}"><i data-lucide="egg"></i>{{ __('Add New Page') }}</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('navigation-manage')
            <li class="side-nav-item {{ isActive('admin.navigation*') }}">
                <a href="{{ route('admin.navigation.menu') }}"><i data-lucide="menu"></i><span>{{ __('Site Navigations')
                        }}</span></a>
            </li>
            @endcan

            @endcanany

            {{-- ************************************************************* Support & Newsletter *********************************************************--}}

            @canany((['subscriber-list','subscriber-mail-send','support-ticket-list','support-ticket-action','email-template','sms-template','sms-template','push-notification-template']))
            <li class="side-nav-item category-title">
                <span>{{ __('Support & Newsletter') }}</span>
            </li>

            @canany(['sms-template','email-template','push-notification-template'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.email-template','admin.template.*']) }}">
                <a href="javascript:void(0);" class="dropdown-link">
                    <i data-lucide="mail"></i><span>{{ __('Templates') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>

                <ul class="dropdown-items">
                    @can('email-template')
                    <li class="{{ isActive('admin.email-template') }}">
                        <a href="{{ route('admin.email-template') }}"><i data-lucide="mail"></i><span>{{ __('Email Template')
                                }}</span></a>
                    </li>
                    @endcan
                    @can('sms-template')
                    <li class="{{ isActive('admin.template.sms.index') }}">
                        <a href="{{ route('admin.template.sms.index') }}"><i data-lucide="message-square"></i><span>{{ __('SMS
                                Template') }}</span></a>
                    </li>
                    @endcan
                    @can('push-notification-template')
                    <li class="{{ isActive('admin.template.notification.index') }}">
                        <a href="{{ route('admin.template.notification.index') }}"><i data-lucide="bell-ring"></i><span>{{
                                __('Push Notification Template') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['subscriber-list','subscriber-mail-send','support-ticket-list','support-ticket-action'])
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.subscriber','admin.ticket*']) }}">
                <a href="javascript:void(0);" class="dropdown-link">
                    <i data-lucide="wrench"></i><span>{{ __('Subscriber & Support') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>
                <ul class="dropdown-items">
                    @canany(['subscriber-list','subscriber-mail-send'])
                    <li class="{{ isActive('admin.subscriber') }}">
                        <a href="{{ route('admin.subscriber') }}"><i data-lucide="mail-open"></i><span>{{ __('All Subscriber')
                                }}</span></a>
                    </li>
                    @endcanany
                    @canany(['support-ticket-list','support-ticket-action'])
                    <li class="{{ isActive('admin.ticket*') }}">
                        <a href="{{ route('admin.ticket.index') }}"><i data-lucide="wrench"></i><span>{{ __('Support Tickets')
                                }}</span></a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany
            @endcanany

            @canany(['manage-cron-job','cron-job-create','cron-job-edit','cron-job-logs','cron-job-run','cron-job-delete','clear-cache','application-details'])
            <li class="side-nav-item category-title">
                <span>{{ __('System') }}</span>
            </li>
            <li class="side-nav-item side-nav-dropdown {{ isActive(['admin.clear-cache','admin.application-info','admin.cron.jobs.*']) }}">
                <a href="javascript:void(0);" class="dropdown-link">
                    <i data-lucide="power"></i><span>{{ __('System') }}</span>
                    <span class="right-arrow"><i data-lucide="chevron-down"></i></span>
                </a>
                <ul class="dropdown-items">
                    @can('manage-cron-job')
                    <li class="{{ isActive('admin.cron.jobs.*') }}">
                        <a href="{{ route('admin.cron.jobs.index') }}"><i data-lucide="alarm-clock"></i><span>{{ __('Cron Jobs') }}</span></a>
                    </li>
                    @endcan
                    @can('clear-cache')
                    <li class="{{ isActive('admin.clear-cache') }}">
                        <a href="{{ route('admin.clear-cache') }}"><i data-lucide="trash-2"></i><span>{{ __('Clear Cache') }}</span></a>
                    </li>
                    @endcan
                    @can('application-details')
                    <li class="{{ isActive('admin.application-info') }}">
                        <a href="{{ route('admin.application-info') }}">
                            <i data-lucide="app-window"></i>
                            <span>{{ __('Application Details') }}</span>
                            <span class="badge yellow-color">{{ config('app.version') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany
        </ul>
    </div>
</div>
