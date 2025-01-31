@php
    $testimonials = App\Models\Testimonial::all();
@endphp

<!-- Testimonial area start -->
<section class="testimonial-area section-space">
    <div class="container">
        <div class="row section-title-space justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="section-title-wrapper text-center">
                    <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['title_small'] }}</span>
                    <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['title_big'] }}</h2>
                </div>
            </div>
        </div>
        <div class="wrapper position-relative">
            <div data-aos="fade-up" data-aos-duration="2500" class="row">
                <div class="col-xxl-12">
                    <div class="swiper testimonial-active">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $content)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="testimonial-content">
                                        <div class="feedback-quote-wrap position-relative">
                                            <div class="feedback__quote">
                                                <svg width="65" height="44" viewBox="0 0 65 44" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g opacity="0.2">
                                                        <path
                                                            d="M26.1065 0H0.532785C0.234282 0 0 0.235948 0 0.536572V26.292C0 26.5926 0.234282 26.8286 0.532785 26.8286H14.5338C12.6369 37.9672 4.60236 42.9472 4.51803 43.0119C4.32656 43.1197 4.21953 43.3772 4.28375 43.6132C4.34797 43.8275 4.56085 44 4.79514 44C20.3102 44 24.8066 32.9681 26.1066 26.4011C26.6394 23.8476 26.6394 22.0652 26.6394 22.0005V0.536451C26.6394 0.235827 26.405 0 26.1065 0Z"
                                                            fill="#F49E57" />
                                                        <path
                                                            d="M64.4672 0H38.8934C38.5949 0 38.3606 0.235948 38.3606 0.536572V26.292C38.3606 26.5926 38.5949 26.8286 38.8934 26.8286H52.8944C50.9976 37.9672 42.963 42.9472 42.8787 43.0119C42.6872 43.1197 42.5801 43.3772 42.6444 43.6132C42.7086 43.8275 42.9215 44 43.1558 44C58.6708 44 63.1672 32.9681 64.4672 26.4011C65 23.8476 65 22.0652 65 22.0005V0.536451C65 0.235827 64.7657 0 64.4672 0Z"
                                                            fill="#F49E57" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="description">
                                            {{ $content->message }}
                                        </p>
                                        <div class="testimonial-author">
                                            <div class="testimonial-author-thumb-3">
                                                @if(content_exists($content->picture))
                                                <img src="{{ asset($content->picture) }}" alt="image not found">
                                                @endif
                                            </div>
                                            <div class="testimonial-author-info">
                                                <h4 class="title">{{ $content->name }}</h4>
                                                <p class="info">{{ $content->designation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- If we need navigation buttons -->
            <div class="testimonial-navigation d-flex justify-content-md-end">
                <button class="testimonial-button-prev"><i class="fa-regular fa-arrow-left-long"></i></button>
                <button class="testimonial-button-next"><i class="fa-regular fa-arrow-right-long"></i></button>
            </div>
        </div>
    </div>
</section>
<!-- Testimonial area end -->
