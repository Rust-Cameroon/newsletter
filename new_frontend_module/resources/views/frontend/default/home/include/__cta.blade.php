
@php
    $data = json_decode(getLandingData('cta')?->data,true);
@endphp

<!-- Newsletter area start -->
<section  class="newsletter-area position-relative z-index-11">
    <div class="container">
        <div class="newsletter-wrapper" data-background="{{ asset('/front/images/shapes/newsletter-mask.png') }}">
            <div class="newsletter-grid">
                <div data-aos="fade-up" data-aos-duration="1000" class="newsletter-content">
                    <h2 class="title text-white">
                        {{ $data['title'] }}
                    </h2>
                    <p class="description text-white">
                        {{ $data['description'] }}
                    </p>
                </div>
                <div data-aos="fade-up" data-aos-duration="1500" class="button">
                    <a class="gradient-btn" href="{{ $data['button_url'] }}" target="{{ $data['button_target'] }}"><span><i class="{{ $data['button_icon'] }}"></i></span>{{ $data['button_label'] }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter area end -->
