@php
    $landingContent =\App\Models\LandingContent::where('type','bankingsolution')->where('locale',app()->getLocale())->get();
@endphp

<!-- Features area start -->
<section class="features-area fix position-relative section-space">
    <div class="container">
        <div class="row section-title-space justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-8">
                <div class="section-title-wrapper text-center">
                    <span data-aos="fade-up" data-aos-duration="1500" class="section-subtitle">
                        {{ $data['title_small'] }}
                    </span>
                    <h2 data-aos="fade-up" data-aos-duration="2000" class="section-title">
                        {{ $data['title_big'] }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="row gy-30 align-items-end">
            @foreach($landingContent as $content)
            @php
                $colors = ['is-warning','is-info','is-success','is-purplish','is-danger'];
            @endphp
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="features-item {{ $colors[$loop->index] ?? '' }}" data-aos="fade-up" data-aos-duration="1000">
                    <div class="icon">
                        <span><i data-lucide="{{ $content->icon }}"></i></span>
                    </div>
                    <h3 class="title">{{ $content->title }}</h3>
                    <p class="description">
                        {{ $content->description }}
                    </p>
                    @if(file_exists(base_path('assets/'.$content->photo)))
                    <div class="thumb">
                        <img src="{{ asset($content->photo) }}" alt="features thumb not found">
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="features-shapes">
        <div class="shape-one">
            <img data-parallax='{"y" : 200, "smoothness": 20}' src="{{ asset('/front/images/features/features-shape.png') }}"
                alt="shape not found">
        </div>
    </div>
</section>
<!-- Features area end -->
