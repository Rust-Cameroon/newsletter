@extends('errors.layout')
@section('title')
    {{ __('Not Found') }}
@endsection
@section('content')
    <img src="/assets/global/materials/404.png" class="unusual-page-img" alt="">
    <p class="description">{{ __('NOT FOUND') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>
@endsection
