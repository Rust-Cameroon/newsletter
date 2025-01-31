@php
    $landingContent =\App\Models\LandingContent::where('type','faq')->where('locale',app()->getLocale())->get();
@endphp
<!-- FAQ area start -->
<section class="faq-area fix position-relative section-space include-bg"
    data-background="{{ asset('/front/images/bg/faq-bg-pattern.png') }}">
    <div class="container">
        <div class="section-title-wrapper text-center section-title-space">
            <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['title_small'] }}</span>
            <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['title_big'] }}</h2>
        </div>
        <div class="row align-items-center gy-50">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="faq-thumb" data-aos="fade-right">
                    @if(content_exists($data['left_img']))
                    <img class="thumb-normal" src="{{ asset($data['left_img']) }}" alt="faq thumb bot found">
                    @endif
                    @if(content_exists($data['left_img']))
                    <img class="thumb-dark" src="{{ asset($data['left_img']) }}" alt="faq thumb bot found">
                    @endif
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="td-faq style-three">
                    <div class="accordion" id="accordionExample">
                        @foreach($landingContent as $content)
                        <div data-aos="fade-up" data-aos-duration="1000" class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $content->id }}">
                                <button class="accordion-button {{ $loop->iteration != 1 ? 'collapsed' : '' }} " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $content->id }}" aria-expanded="{{ $loop->iteration == 1 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $content->id }}">
                                    {{ $content->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $content->id }}" class="accordion-collapse @if($loop->iteration == 1) collapse show @else collapse  @endif"
                                aria-labelledby="heading{{ $content->id }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>
                                        {!! nl2br(e($content->description)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="faq-shapes">
        <div class="shape-two">
            <img data-parallax='{"y" : -120, "smoothness": 20}' src="{{ asset('/front/images/shapes/faq-02.png') }}" alt="faq shape not found">
        </div>
    </div>
</section>
<!-- FAQ area end -->
