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

    @yield('content')

    @include('frontend::include.__script')
</body>
</html>


