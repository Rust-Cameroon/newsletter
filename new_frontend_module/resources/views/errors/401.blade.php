@extends('errors.layout')
@section('title')
    {{ __('Unauthorized') }}
@endsection
@section('content')
    <img src="/assets/global/materials/401.svg" class="unusual-page-img" alt="">
    <h2 class="title">401</h2>
    <p class="description">{{ __('Unauthorized') }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>
@endsection
