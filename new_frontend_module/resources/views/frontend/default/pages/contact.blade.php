@extends('frontend::pages.index')
@section('title')
    {{ $data['title'] }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')

    <!-- Contact card area start -->
    <Section class="contact-card-area fix position-relative section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="section-title-wrapper text-center section-title-space">
                        <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['title_small'] }}</span>
                        <h2 data-aos="fade-up" data-aos-duration="1400" class="section-title mb-4">{{ $data['title_big'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-30 justify-content-center" data-aos="fade-up" data-aos-duration="2000">
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="contact-card">
                        <div class="content">
                            <div class="icon">
                                <span><i class="{{ $data['widget_one_icon'] }}"></i></span>
                            </div>
                            <h3 class="title">{{ $data['widget_one_title'] }}</h3>
                            <p class="description">{{ $data['widget_one_description'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="contact-card">
                        <div class="content">
                            <div class="icon">
                                <span><i class="{{ $data['widget_two_icon'] }}"></i></span>
                            </div>
                            <h3 class="title">{{ $data['widget_two_title'] }}</h3>
                            <p class="description">{{ $data['widget_two_description'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="contact-card">
                        <div class="content">
                            <div class="icon">
                                <span><i class="{{ $data['widget_three_icon'] }}"></i></span>
                            </div>
                            <h3 class="title">{{ $data['widget_three_title'] }}</h3>
                            <p class="description">{{ $data['widget_three_description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <!-- Contact card area end -->

    <!-- contact form area start -->
    <Section class="contact-form-area gray-bg section-space include-bg"
        data-background="{{ asset($data['form_background_img']) }}">
        <div class="container">
            <div class="row gy-30 justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="contact-form-content" data-aos="fade-up" data-aos-duration="1500">
                        <div class="section-title-wrapper">
                            <h2 class="section-title text-white mb-4">{{ $data['form_title'] }}</h2>
                            <p class="description text-white-80">
                                {{ $data['form_description'] }}
                            </p>
                        </div>
                        <div class="contact-info">
                            <div class="item">
                                <div class="icon">
                                    <span><i class="{{ $data['contact_one_icon'] }}"></i></span>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{ $data['contact_one_title'] }}</h3>
                                    <span class="info">{{ $data['contact_one_value'] }}</span>
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <span><i class="{{ $data['contact_two_icon'] }}"></i></span>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{ $data['contact_two_title'] }}</h3>
                                    <span class="info">{{ $data['contact_two_value'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="contact-form" data-aos="fade-right" data-aos-duration="1000">
                        <form id="contact-form" action="{{ route('mail-send') }}" method="POST">
                            @csrf
                            <div class="contact-input-wrapper">
                                <div class="row">
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input-title">
                                                <label for="Name">{{ __('Name') }}<span>*</span></label>
                                            </div>
                                            <div class="contact-input">
                                                <input name="name" id="name" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input-title">
                                                <label for="email">{{ __('Email Address') }}<span>*</span></label>
                                            </div>
                                            <div class="contact-input">
                                                <input name="email" id="email" type="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input-title">
                                                <label for="pnumber">{{ __('Subject') }}<span>*</span></label>
                                            </div>
                                            <div class="contact-input">
                                                <input name="subject" id="subject" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="contact-input-box">
                                            <div class="contact-input-title">
                                                <label for="pnumber">{{ __('Message') }}<span>*</span></label>
                                            </div>
                                            <div class="contact-input">
                                                <textarea name="msg"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-btn">
                                <button class="td-primary-btn" type="submit">{{ __('Submit Now') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <!-- contact form area end -->
@endsection
