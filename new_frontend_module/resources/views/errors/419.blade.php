@extends('errors.layout')
@section('title')
    {{ __('Page Expired') }}
@endsection
@section('content')
    <img src="/assets/global/materials/500.svg" class="unusual-page-img" alt="">
    <h2 class="title">419</h2>
    <p class="description">{{ __('Page Expired') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>

@endsection
