@extends('errors.layout')
@section('title')
    {{ __('Forbidden') }}
@endsection
@section('content')
    <img src="/assets/global/materials/403.svg" class="unusual-page-img" alt="">
    <h2 class="title">403</h2>
    <p class="description">{{ __($exception->getMessage()) ?: 'Forbidden' }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>
@endsection
