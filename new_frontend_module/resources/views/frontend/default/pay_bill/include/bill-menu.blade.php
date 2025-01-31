<div class="transfer-top-btns mb-4">
    <a href="{{ route('user.pay.bill.airtime') }}" class="site-btn-sm {{ isActive('user.pay.bill.airtime') }}"><i data-lucide="phone"></i>{{ __('Airtime') }}</a>
    <a href="{{ route('user.pay.bill.electricity') }}" class="site-btn-sm {{ isActive('user.pay.bill.electricity') }}"><i data-lucide="zap"></i>{{ __('Electricity') }}</a>
    <a href="{{ route('user.pay.bill.internet') }}" class="site-btn-sm {{ isActive('user.pay.bill.internet') }}"><i data-lucide="wifi"></i>{{ __('Internet ') }}</a>
    <a href="{{ route('user.pay.bill.data.bundle') }}" class="site-btn-sm {{ isActive('user.pay.bill.data.bundle') }}"><i data-lucide="database"></i>{{ __('Data Bundle ') }}</a>
    <a href="{{ route('user.pay.bill.cables') }}" class="site-btn-sm {{ isActive('user.pay.bill.cables') }}"><i data-lucide="tv"></i>{{ __('Cables') }}</a>
    <a href="{{ route('user.pay.bill.toll') }}" class="site-btn-sm {{ isActive('user.pay.bill.toll') }}"><i data-lucide="type"></i>{{ __('Toll') }}</a>
</div>
