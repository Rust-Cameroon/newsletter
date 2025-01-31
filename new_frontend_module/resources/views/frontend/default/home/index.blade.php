@extends('frontend::layouts.app')
@section('title')
    {{ __('Home') }}
@endsection
@section('meta_keywords')
{{ trim(setting('meta_keywords','meta')) }}
@endsection
@section('meta_description')
{{ trim(setting('meta_description','meta')) }}
@endsection

@section('content')

        @foreach($homeContent as $content)
            @php
                $data = json_decode($content->data,true);
            @endphp
            @include('frontend::home.include.__'.$content->code,['data' => $data])
        @endforeach

@endsection
