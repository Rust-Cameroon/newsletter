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
@php
    $portfolios = App\Models\Portfolio::where('status',true)->get();
@endphp
        <!-- Portfolio area start -->
        <section class="portfolio-area fix position-relative section-space portfolio-space" data-aos="fade-up" data-aos-duration="1500">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($portfolios as $portfolio)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="single-badge unlocked">
                            <div class="badge">
                                <div class="img"><img src="{{ asset($portfolio->icon) }}" alt=""></div>
                            </div>
                            <div class="content">
                                <h3 class="title">{{ $portfolio->portfolio_name }}</h3>
                                <p class="description">{{ $portfolio->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Portfolio area end -->
@endsection
