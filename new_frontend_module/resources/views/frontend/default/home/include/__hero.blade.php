
<!-- Banner area start -->
<section class="banner-area">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-xxl-7 col-xl-6 col-lg-6">
                <div class="banner-content-wrapper">
                    <div class="banner-content">
                        <span data-aos="fade-right" data-aos-duration="1000" class="sbu-title">
                            {{ $data['sub_title'] }}
                        </span>
                        <h1 data-aos="fade-right" data-aos-duration="1500" class="title">
                            {{ $data['hero_title'] }}
                            <span>{{ $data['hero_colour_full_title'] }}</span>
                        </h1>
                        <p data-aos="fade-up" data-aos-duration="2000" class="description">
                            {{ $data['hero_content'] }}
                        </p>
                        <div class="btn-wrrapper d-flex gap-3 align-items-center" data-aos="fade-up"
                            data-aos-duration="2500">
                            <a class="gradient-btn" href="{{ $data['hero_button1_url'] }}" target="{{ $data['hero_button1_target'] }}">
                                {{ $data['hero_button1_level'] }}
                                <span><i class="{{ $data['hero_button1_icon'] }}"></i></span>
                            </a>

                            <a class="text-btn" href="{{ $data['hero_button2_url'] }}" target="{{ $data['hero_button2_target'] }}">
                                {{ $data['hero_button2_lavel'] }}
                                <span><i class="{{ $data['hero_button2_icon'] }}"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-xl-6 col-lg-6">
                <div class="banner-thumb-wrapper" data-aos="fade-left" data-aos-duration="2000">
                    <div class="banner-thumb">
                        @if(content_exists($data['hero_right_img']))
                        <img src="{{ asset($data['hero_right_img']) }}"
                            alt="thumb not found">
                        @endif
                    </div>
                    <div class="user-one">
                        @if(content_exists($data['hero_right_top_img']))
                        <img src="{{ asset($data['hero_right_top_img']) }}" alt="user not found">
                        @endif
                    </div>
                    <div class="user-two">
                        @if(content_exists($data['hero_right_down_img']))
                        <img src="{{ asset($data['hero_right_down_img']) }}" alt="user not found">
                        @endif
                    </div>
                    <div class="shape-text">
                        <span>
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="24" fill="#40D9BD" />
                                <path
                                    d="M32 25.0004C32 30.0004 28.5 32.5005 24.34 33.9505C24.1222 34.0243 23.8855 34.0207 23.67 33.9405C19.5 32.5005 16 30.0004 16 25.0004V18.0004C16 17.7352 16.1054 17.4809 16.2929 17.2933C16.4804 17.1058 16.7348 17.0004 17 17.0004C19 17.0004 21.5 15.8004 23.24 14.2804C23.4519 14.0994 23.7214 14 24 14C24.2786 14 24.5481 14.0994 24.76 14.2804C26.51 15.8104 29 17.0004 31 17.0004C31.2652 17.0004 31.5196 17.1058 31.7071 17.2933C31.8946 17.4809 32 17.7352 32 18.0004V25.0004Z"
                                    stroke="black" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M21 24L23 26L27 22" stroke="black" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <h6>
                            {{ $data['hero_right_animate_title'] }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-shapes">
        <div class="shape-one">
            <img data-parallax='{"y" : 50, "smoothness": 20}' src="{{ asset($data['hero_down_shape_img']) }}"
                alt="shape not found">
        </div>
        <div class="shape-two upDown">
            @if(content_exists($data['hero_left_shape_img']))
            <img src="{{ asset($data['hero_left_shape_img']) }}" alt="shape not found">
            @endif
        </div>
        <div class="shape-round"></div>
        <div class="shape-round-two"></div>
    </div>
</section>
<!-- Banner area end -->
