@extends('errors.layout')
@section('title')
    {{ __('Too Many Requests') }}
@endsection
@section('content')
    <img src="/assets/global/materials/500.svg" class="unusual-page-img" alt="">
    <h2 class="title">429</h2>
    <p class="description">{{ __('Too Many Requests') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>

@endsection
