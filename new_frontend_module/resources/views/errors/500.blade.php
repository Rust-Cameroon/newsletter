@extends('errors.layout')
@section('title')
    {{ __('Server Error') }}
@endsection
@section('content')
    <img src="/assets/global/materials/500.png" class="unusual-page-img" alt="">
    <p class="description">{{ __('Server Error') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>

@endsection
