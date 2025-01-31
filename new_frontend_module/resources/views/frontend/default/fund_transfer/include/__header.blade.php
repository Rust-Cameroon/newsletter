<div class="col-xl-12 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-body transfer-top-btns">
            <a href="{{ route('user.fund_transfer.index') }}" class="site-btn-sm {{ isActive('user.fund_transfer.index') }}"><i data-lucide="send"></i> Transfer</a>
            <a href="{{ route('user.fund_transfer.beneficiary.index') }}" class="site-btn-sm {{ isActive('user.fund_transfer.beneficiary.index') }}"><i data-lucide="user-check"></i> Beneficiary list</a>
            <a href="{{ route('user.fund_transfer.transfer.wire') }}" class="site-btn-sm {{ isActive('user.fund_transfer.transfer.wire') }}"><i data-lucide="wifi"></i> Wire transfer</a>
            <a href="{{ route('user.fund_transfer.transfer.log') }}" class="site-btn-sm {{ isActive('user.fund_transfer.transfer.log') }}"><i data-lucide="alert-circle"></i> Transfer history</a>
        </div>
    </div>
</div>
