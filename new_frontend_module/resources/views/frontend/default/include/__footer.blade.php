@php
    $footerContent = json_decode(\App\Models\LandingPage::where('locale',app()->getLocale())->where('code','footer')->first()?->data,true);
@endphp

@if(!Route::is('home'))
@include('frontend::home.include.__cta')
@endif
<!-- Footer area start -->
<footer>
    <div class="footer-area footer-primary position-relative z-index-1 include-bg"
        data-background="{{ asset('/') }}/front/images/bg/footer-ring.png">
        <div class="container">
            <div class="footer-main">
                <div class="row gy-50">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-widget-1-1">
                            @php
                                $height = setting('site_logo_height','global') == 'auto' ? 'auto' : setting('site_logo_height','global').'px';
                                $width = setting('site_logo_width','global') == 'auto' ? 'auto' : setting('site_logo_width','global').'px';
                            @endphp
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset(setting('site_logo','global')) }}" style="height:{{ $height }};width:{{ $width }};max-width:none" alt="logo not found">
                                </a>
                            </div>
                            <div class="footer-content">
                                <p>
                                    {{ $footerContent['widget_left_description'] }}
                                </p>
                                <h6 class="title">{{ __('Subscribe Now') }}</h6>
                                <form action="{{ route('subscriber') }}" method="post">
                                    @csrf
                                    <div class="footer-newsletter-from">
                                        <div class="footer-newsletter-input position-relative">
                                            <input type="text" placeholder="Enter your email" name="email" autocomplete="off">
                                            <button class="footer-round-btn" type="submit">{{ __('Subscribe') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @foreach($navigations as $navigation)
                        @php
                            $columns = $loop->first ? 'col-xxl-3 col-xl-3 col-lg-3' : 'col-xxl-2 col-xl-2 col-lg-2';
                        @endphp
                    <div class="{{ $columns }} col-md-6 col-sm-6">
                        <div class="footer-widget-1-{{ $loop->iteration+1 }}">
                            <div class="footer-widget-title">
                                <h5>{{ $footerContent['widget_title_'.$loop->iteration] ?? '' }}</h5>
                            </div>
                            <div class="footer-link">
                                <ul>
                                    @foreach($navigation as $menu)
                                        @if($menu->page_id == null)
                                            <li><a href="{{ $menu->url }}">{{ $menu->tname }}</a></li>
                                        @else
                                            <li><a href="{{ url($menu->url) }}">{{ $menu->tname }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget-1-4 justify-content-lg-end">
                            <div class="footer-widget-title">
                                <h5>{{ $footerContent['widget_title_3'] ?? '' }}</h5>
                            </div>
                            <div class="footer-contact">
                                <div class="footer-info">
                                    <div class="single-item">
                                        <h6 class="title">{{ $footerContent['contact_email_title'] }}</h6>
                                        <div class="footer-info-item">
                                            <div class="footer-info-icon">
                                                <span><i class="fa-solid fa-envelope"></i></span>
                                            </div>
                                            <div class="footer-info-text">
                                                <span><a
                                                        href="mailto:{{ $footerContent['contact_email_address'] }}">{{ $footerContent['contact_email_address'] }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-item">
                                        <h6 class="title">{{ $footerContent['contact_telegram_title'] }}</h6>
                                        <div class="footer-info-item">
                                            <div class="footer-info-icon">
                                                <span><i class="fa-brands fa-telegram"></i></span>
                                            </div>
                                            <div class="footer-info-text">
                                                <span><a href="{{ $footerContent['contact_telegram_link'] }}" target="_blank">{{ $footerContent['contact_telegram_link'] }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom">
                        <div class="footer-copyright">
                            <p>{{ $footerContent['copyright_text'] }}</p>
                        </div>
                        <div class="footer-social">
                            @foreach(\App\Models\Social::all() as $social)
                            <a href="{{ url($social->url) }}"><i class="{{ $social->class_name }}"></i></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-shapes">
            <div class="shape-one">
                <img src="{{ asset('/') }}/front/images/shapes/footer/shape-01.png" alt="shape not found">
            </div>
            <div class="shape-two">
                <img src="{{ asset('/') }}/front/images/shapes/footer/shape-02.png" alt="shape not found">
            </div>
        </div>
    </div>
</footer>
<!-- Footer area end -->
