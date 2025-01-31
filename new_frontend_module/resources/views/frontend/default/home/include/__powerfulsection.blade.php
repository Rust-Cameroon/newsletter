@php
    $landingContent =\App\Models\LandingContent::where('type','powerfulsection')->where('locale',app()->getLocale())->get();
@endphp

<!-- Our solutions area start -->
<section class="our-solutions-area position-relative z-index-11 fix section-space include-bg" data-background="{{ asset('/front/images/solutions/bg-pattern.png') }}">
    <div class="container">
        <div class="row gy-30">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="our-solutions-left">
                    <div class="section-title-wrapper" data-aos="fade-up" data-aos-duration="1000">
                        <span class="section-subtitle bg-lightest">{{ $data['title_small'] }}</span>
                        <h2 class="section-title text-white">{{ $data['title_big'] }}</h2>
                    </div>
                    <div class="content" data-aos="fade-up" data-aos-duration="2000">
                        <p class="description">
                            {{ $data['description'] }}
                        </p>
                    </div>
                    <div class="thumb-wrap" data-aos="fade-up" data-aos-duration="3000">
                        @if(content_exists($data['left_img']))
                        <div class="thumb" style="-webkit-mask-image:url('{{ asset($data['mask_shape_img']) }}');mask-image:url('{{ asset($data['mask_shape_img']) }}')">
                            <img src="{{ asset($data['left_img']) }}" alt="solutions not found">
                        </div>
                        @endif
                        @if(content_exists($data['mask_shape_img']))
                        <div class="mask-shape">
                            <img src="{{ asset($data['mask_shape_img']) }}" alt="mask shape">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="our-solutions-right" data-aos="fade-up" data-aos-duration="2000">
                    @foreach ($landingContent as $content)
                    <div class="our-solutions-item">
                        <div class="content">
                            <div class="title-inner">
                                <div class="icon">
                                    <span>
                                        <img src="{{ asset($content->icon) }}" alt="Not found">
                                    </span>
                                </div>
                                <h3 class="title">{{ $content->title }}</h3>
                            </div>
                            <p class="description">
                                {{ $content->description }}
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="our-solutions-shapes">
        <div class="round-glow"></div>
        <div class="shape-one">
            @if(content_exists($data['left_shape_img']))
            <img data-parallax='{"y" : 175, "smoothness": 20}' src="{{ asset($data['left_shape_img']) }}"
                alt="shape not found">
            @endif
        </div>
    </div>
</section>

<!-- Our solutions area end -->
