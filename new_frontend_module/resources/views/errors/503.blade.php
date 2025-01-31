@extends('errors.layout')
@section('title')
    {{ __('Service Unavailable') }}
@endsection
@section('content')
    <img src="/assets/global/materials/503.svg" class="unusual-page-img" alt="">
    <h2 class="title">503</h2>
    <p class="description">{{ __('Service Unavailable') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>
@endsection
