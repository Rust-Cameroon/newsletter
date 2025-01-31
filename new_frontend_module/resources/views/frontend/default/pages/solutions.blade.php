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

    @php
        $landingContent =\App\Models\LandingContent::where('type','solutions')->where('locale',app()->getLocale())->get();
    @endphp
    <!-- services area start -->
    <section class="services-area position-relative fix section-space">
        <div class="inner-pages-shapes">
            @if(content_exists($data['shape_one_img']))
            <div class="shape-one">
                <img src="{{ asset($data['shape_one_img']) }}" alt="shape not found">
            </div>
            @endif
            @if(content_exists($data['shape_two_img']))
            <div class="shape-two">
                <img data-parallax='{"y" : -120, "smoothness": 20}' src="{{ asset($data['shape_two_img']) }}" alt="shape not found">
            </div>
            @endif
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="services-grid">
                        @foreach ($landingContent as $content)
                        <div class="services-item" data-aos="fade-up" data-aos-duration="1000">
                            <div class="content">
                                <div class="icon">
                                    <span><i class="{{ $content->icon }}"></i></span>
                                </div>
                                <h3 class="title">{{ $content->title }}</h3>
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
    </section>
    <!-- services area end -->

    <!-- section  -->
    @if(isset($data->section_id) && $data->section_id)

        @php
            $section_ids = is_array(json_decode($data['section_id'])) ? json_decode($data['section_id']) : [];
            $commaIds = implode(',',$section_ids);
            $sections = \App\Models\LandingPage::whereIn('id',$section_ids)
                                                ->when($commaIds != null && !blank($commaIds),function($query) use($commaIds) {
                                                    $query->orderByRaw("FIELD(id, $commaIds)");
                                                })
                                                ->get();
        @endphp

        @foreach ($sections as $section)
            @include('frontend::home.include.__'.$section->code,['data' => json_decode($section->data, true) ])
        @endforeach

    @endif
    <!-- section end-->
@endsection
