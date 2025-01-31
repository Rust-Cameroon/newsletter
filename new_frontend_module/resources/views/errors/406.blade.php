@extends('errors.layout')
@section('title')
    {{ __('Not acceptable') }}
@endsection
@section('content')
    <img src="/assets/global/materials/401.svg" class="unusual-page-img" alt="">
    <p class="description">{{ __($exception->getMessage()) ?: 'Not Acceptable' }}</p>
    <a href="{{route('home')}}" class="back-to-home-btn">{{ __('Back to Home') }}</a>
@endsection
