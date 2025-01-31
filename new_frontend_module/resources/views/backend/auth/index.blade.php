<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--Head-->
@include('backend.include.__head')
<!--/Head-->
<body>


<!--Auth Page-->
<div class="admin-auth">
    <!--Notification-->
    @include('global._notify')
    
    @yield('auth-content')
</div>
<!--/Auth Page-->

<!--Script-->
@include('backend.include.__script')
<!--/Script-->

</body>
</html>
