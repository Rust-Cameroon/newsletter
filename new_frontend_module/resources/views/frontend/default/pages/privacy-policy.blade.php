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
    <!-- Privacy policy area start -->
    <section class="faq-area position-relative section-space">
        <div class="container">
            <div class="privacy-policy-content">
                <div class="privacy-item">
                    {!! $data['content'] !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Privacy policy area end -->
@endsection
