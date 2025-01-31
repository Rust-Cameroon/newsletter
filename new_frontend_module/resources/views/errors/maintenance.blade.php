@extends('errors.layout')
@section('title')
    {{ __('Site Maintenance') }}
@endsection
@section('content')
    <img src="/assets/global/materials/maintenance.svg" class="unusual-page-img" alt="">
    <h2 class="title">{{ setting('maintenance_title','site_maintenance') }}</h2>
    <p class="description">{{ setting('maintenance_text','site_maintenance') }}</p>
@endsection

