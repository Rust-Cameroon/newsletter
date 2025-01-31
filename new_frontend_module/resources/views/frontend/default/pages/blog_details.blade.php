@extends('frontend::layouts.app')
@section('title')
    {{ $blog->title }}
@endsection
@section('content')
    {{-- <section class="section-style-2 light-blue-bg">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-12 col-sm-12 order-xl-2 order-lg-2 order-md-2 order-sm-2 order-xxl-1 order-1">
                    <div class="site-sidebar">
                        <div class="single-sidebar">
                            <h3>{{ $data['sidebar_widget_title'] }}</h3>
                            <ul>
                                @foreach($blogs as $id => $title)
                                    <li><a href="{{ route('blog-details',$id) }}">{{ Str::limit($title,35)   }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12 order-xl-1 order-lg-1 order-md-1 order-sm-1 order-xxl-2">
                    <div class="blog-details">
                        <img class="big-thumb" src="{{ asset($blog->cover) }}" alt=""/>
                        <div class="frontend-editor-data">
                            {!! $blog->details !!}
                        </div>
                    </div>
                    <div class="post-share-and-tag row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="social">
                                <span>Share:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('blog-details',$blog->id) }}"
                                   class="cl-facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ route('blog-details',$blog->id) }}"
                                   class="cl-twitter"><i class="fab fa-twitter"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ route('blog-details',$blog->id) }}"
                                   class="cl-pinterest"><i class="fab fa-linkedin"></i></a>
                                <a href="https://wa.me/?text={{ route('blog-details',$blog->id) }}"
                                   class="cl-pinterest"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Breadcrumb area start -->
    <section class="breadcrumb-area style-one position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-8">
                    <div class="breadcrumb-content-wrapper text-center">
                        <div class="breadcrumb-content">
                            <h1 class="title">{{ $blog->title }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-shapes">
            <div class="shape-one">
                <img src="{{ asset('front/images/shapes/alpha.png') }}" alt="shape not found">
            </div>
            <div class="shape-two">
                <img src="{{ asset('front/images/shapes/nine.png') }}" alt="shape not found">
            </div>
            <div class="shape-three">
                <img src="{{ asset('front/images/shapes/triangle-light.png') }}" alt="shape not found">
            </div>
        </div>
    </section>
    <!-- Breadcrumb area end -->

    <!-- Postbox area start -->
    <section class="postbox-area position-relative fix section-space"  data-aos="fade-up" data-aos-duration="15 00">
        <div class="inner-pages-shapes">
            <div class="shape-one">
                <img src="{{ asset('front/images/shapes/nine.png') }}" alt="shape not found">
            </div>
            <div class="shape-two">
                <img data-parallax='{"y" : -120, "smoothness": 20}' src="{{ asset('front/images/shapes/alpha-left.png') }}" alt="shape not found">
            </div>
        </div>
        <div class="container">
            <div class="row g-40">
                <div class="col-xxl-8 col-xl-8 col-lg-7">
                    <div class="postbox-wrapper">
                        <div class="postbox-item mb-4">
                            <div class="postbox-text">
                                {!! $blog->details !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-5">
                    <div class="sidebar-wrapper sidebar-active-sticky">
                        <div class="sidebar-widget mb-40">
                            <h3 class="sidebar-widget-title">{{ $data['sidebar_widget_title'] }}</h3>
                            <div class="sidebar-widget-content">
                                <div class="sidebar-post">
                                    @foreach($blogs as $item)
                                    <div class="rc-post-item">
                                        <div class="rc-post-thumb">
                                            <a href="{{ route('blog-details',$item->id) }}"><img
                                                    src="{{ asset($item->cover) }}"
                                                    alt="image not found"></a>
                                        </div>
                                        <div class="rc-post-content">
                                            <h5 class="rc-post-title">
                                                <a href="{{ route('blog-details',$item->id) }}">{{ $item->title }}</a>
                                            </h5>
                                            <div class="rc-meta">
                                                <p>{{ Str::words(strip_tags($item->details),12) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Postbox area start -->
@endsection
