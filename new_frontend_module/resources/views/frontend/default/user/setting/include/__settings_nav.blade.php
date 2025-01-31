<div class="col-xl-12 col-lg-12 col-md-12 col-12">
    <div class="site-card">
        <div class="site-card-body transfer-top-btns">
            <a href="{{ route('user.setting.show') }}" class="site-btn-sm {{ isActive('user.setting.show') }}"><i data-lucide="user"></i>{{ __('Profile Settings') }}</a>
            <a href="{{ route('user.change.password') }}" class="site-btn-sm {{ isActive('user.change.password') }}"><i data-lucide="key"></i>{{ __('Change Password') }}</a>
            <a href="{{ route('user.setting.security') }}" class="site-btn-sm {{ isActive('user.setting.security') }}"><i data-lucide="lock"></i>{{ __('Security Settings') }}</a>
            <a href="{{ route('user.kyc') }}" class="site-btn-sm {{ isActive('user.kyc*') }}"><i data-lucide="file-text"></i>{{ __('ID Verification') }}</a>
            <a href="{{ route('user.notification.all') }}" class="site-btn-sm {{ isActive('user.notification.all') }}"><i data-lucide="bell"></i>{{ __('All Notifications') }}</a>
            <a href="{{ route('user.setting.action') }}" class="site-btn-sm  {{ isActive('user.setting.action') }}"><i data-lucide="settings"></i>{{ __('Account Closing') }}</a>
        </div>
    </div>
</div>
