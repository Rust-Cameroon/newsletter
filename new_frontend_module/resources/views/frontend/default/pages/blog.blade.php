@extends('frontend::pages.index')
@section('title')
    {{ $data->title }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')

    @php
        $blogs = \App\Models\Blog::where('locale',app()->getLocale())->latest()->paginate(9);
    @endphp

    <!-- Postbox area start -->
    <section class="postbox-area position-relative fix section-space" data-aos="fade-up" data-aos-duration="15 00">
        <div class="container">
            <div class="row gy-5">
                @foreach ($blogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-6">
                    <article class="blog-grid-item" data-aos="fade-up" data-aos-duration="1000">
                        <div class="blog-thumb">
                            <a href="{{ route('blog-details',$blog->id) }}">
                            <img src="{{ asset($blog->cover) }}" alt="{{ $blog->title }}">
                        </a>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta-inner">
                            <div class="date-badge">
                                <span>{{ date('d M Y',strtotime($blog->created_at)) }}</span>
                            </div>
                            <div class="blog-button">
                                <a class="blog-link" href="{{ route('blog-details',$blog->id) }}"><i
                                    class="fa-regular fa-arrow-up-right"></i></a>
                            </div>
                            </div>
                            <h3 class="blog-title">
                            <a href="{{ route('blog-details',$blog->id) }}">{{ $blog->title }}</a>
                            </h3>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            {{ $blogs->links('frontend::pagination.pagination') }}
        </div>
    </section>
    <!-- Postbox area start -->
@endsection
