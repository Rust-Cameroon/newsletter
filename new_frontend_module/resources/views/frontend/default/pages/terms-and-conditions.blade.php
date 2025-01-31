@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')
    <section class="section-style">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="frontend-editor-data">
                        {!! $data['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
