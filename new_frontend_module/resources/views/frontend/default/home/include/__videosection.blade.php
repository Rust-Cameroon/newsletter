<!-- Video area start -->
<section class="video-area position-relative">
    <div class="container">
        <div class="section-title-wrapper text-center section-title-space">
            <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['small_title'] }}</span>
            <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['big_title'] }}</h2>
        </div>
        <div data-aos="fade-up" data-aos-duration="2000" class="video-wrapper">
            <div class="video-thumb">
                @if(content_exists($data['thumbnail_img']))
                <img src="{{ asset($data['thumbnail_img']) }}" alt="video thumb not found">
                @endif
            </div>
            <div class="video-play">
                <a class="play-btn popup-video animate-play" href="{{ $data['video_link'] }}">
                    <span><i class="fa-solid fa-play"></i></span>
                </a>
            </div>
        </div>
    </div>
    <div class="video-thumb-pattern" data-background="{{ asset('/front/images/video/bg-pattern.png') }}">
    </div>
    <div class="video-shapes">
        <div class="shape-one shortUPDown">
            @if(content_exists($data['left_shape_img']))
            <img src="{{ asset($data['left_shape_img']) }}" alt="faq shape not found">
            @endif
        </div>
    </div>
</section>
<!-- Video area end -->
