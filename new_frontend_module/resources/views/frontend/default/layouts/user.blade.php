<!DOCTYPE html>
@php
    $isRtl = isRtl(app()->getLocale());
@endphp
<html lang="{{ app()->getLocale() }}" @if($isRtl) dir="rtl" @endif>
@include('frontend::include.__head')
<body @class([
    'dark-theme' => session()->get('site-color-mode',setting('default_mode')) == 'dark',
    'rtl_mode' => $isRtl
])>

<!--Notification-->
@include('global._notify')

<!-- Dashboard Section -->
<main class="main-user-dahboard">
    @include('frontend::include.__user_side_nav')
    <div class="page-content">
        <div class="main-content">
            @include('frontend::include.__user_header')
            <div class="page-gap">
                <div class="container-fluid">
                    @if(auth()->user()->kyc !== \App\Enums\KYCStatus::Verified->value)
                        @include('frontend::include.__kyc_warning')
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Dashboard Section End -->

@include('frontend::include.__script')
</body>
</html>


