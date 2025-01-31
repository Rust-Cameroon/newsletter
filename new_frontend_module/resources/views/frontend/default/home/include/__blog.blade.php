
<!-- Blog area start -->
<div class="blog-area section-space-top">
    <div class="container">
        <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="section-title-wrapper section-title-space">
                <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['blog_title_small'] }}</span>
                <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['blog_title_big'] }}</h2>
            </div>
        </div>
        <div class="row gy-5">
            @foreach(\App\Models\Blog::where('locale',app()->getLocale())->latest()->take(3)->get() as $blog)
            <div class="col-xxl-4 col-xl-4 col-lg-6">
                <article class="blog-grid-item" data-aos="fade-up" data-aos-duration="1000">
                    <div class="blog-thumb">
                        <a href="{{ route('blog-details',$blog->id) }}">
                            <img src="{{ asset($blog->cover) }}"alt="image not found">
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta-inner">
                            <div class="date-badge">
                                <span>{{ $blog->created_at }}</span>
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
    </div>
</div>
<!-- Blog area start -->
