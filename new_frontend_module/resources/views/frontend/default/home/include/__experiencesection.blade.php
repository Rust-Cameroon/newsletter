@php
    $landingContent =\App\Models\LandingContent::where('type','experiencesection')->where('locale',app()->getLocale())->get();
@endphp

<!-- Experiences area start -->
<div class="experiences-area sectiton-bg position-relative z-index-11">
    <div class="container">
        <div class="row gy-30">
            <div class="col-xxl-7 col-xl-6 col-lg-6">
                <div class="experiences-content">
                    <div class="section-title-wrapper">
                        <span data-aos="fade-up" data-aos-duration="1000"
                            class="section-subtitle bg-lightest">{{ $data['title_small'] }}</span>
                        <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title text-white">
                           {{ $data['title_big'] }}
                        </h2>
                    </div>
                    <p data-aos="fade-up" data-aos-duration="2000" class="description">
                        {{ $data['description'] }}
                    </p>
                    <div data-aos="fade-up" data-aos-duration="2500" class="experiences-info">
                        <div class="list">
                            <ul>
                                @foreach ($landingContent as $content)
                                <li><i data-lucide="{{ $content->icon }}"></i>{{ $content->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if(content_exists($data['right_img']))
            <div class="col-xxl-5 col-xl-6 col-lg-6">
                <div class="experiences-thumb">
                    <img data-aos="fade-left" data-aos-duration="1500"
                        src="{{ asset($data['right_img']) }}" alt="experiences thumb not found">
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="experiences-bg">
        <img src="{{ asset('/front/images/bg/experiences-bg.png') }}" alt="experiences bg not found">
    </div>
    @if(content_exists($data['left_shape_img']))
    <div class="experiences-shapes">
        <div class="shape-one">
            <img src="{{ asset($data['left_shape_img']) }}" alt="cercle shape not found">
        </div>
    </div>
    @endif
</div>
<!-- Experiences area end -->
