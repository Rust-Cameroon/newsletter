@php
    $landingContent =\App\Models\LandingContent::where('type','whychooseus')->where('locale',app()->getLocale())->get();
@endphp

<!-- Why Choose area start -->
<section class="why-choose-area position-relative z-index-11 fix section-space"
    data-background="{{ asset('/front/images/bg/choose-bg.png') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="section-title-wrapper section-title-space text-center">
                    <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle bg-lightest">{{ $data['title_small'] }}</span>
                    <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title text-white">{{ $data['title_big'] }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 col-xl-6">
                <div class="why-choose-wrapper">
                    @foreach($landingContent as $content)
                    <div data-aos="fade-up" data-aos-duration="1500" class="why-choose-timeline">
                        <div class="timeline-icon">
                            <span><i class="{{ $content->icon }}"></i></span>
                        </div>
                        <div class="why-choose-content">
                            <div class="content">
                                <h4 class="title">{{ $content->title }}</h4>
                                <p class="description">
                                    {{ $content->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6">
                <div class="why-choose-thumb">
                    @if(content_exists($data['right_img']))
                    <img data-aos="fade-right" data-aos-duration="1500" src="{{ asset($data['right_img']) }}" alt="thumb not found">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="why-choose-shapes">
        <div class="shape-one shortUPDown">
            <img src="{{ asset('/front/images/shapes/triangle-shape.png') }}" alt="triangle shape not found">
        </div>
        <div class="round"></div>
    </div>
</section>
<!-- Why Choose area end -->
