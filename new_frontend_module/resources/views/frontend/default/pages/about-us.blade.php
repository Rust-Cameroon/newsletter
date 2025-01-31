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
    <!-- About area start -->
    <Section class="about-area position-relative section-space">
        <div class="container">
            <div class="row gy-30 align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="about-content">
                        <div class="section-title-wrapper mb-4">
                            <span data-aos="fade-up" data-aos-duration="1000" class="section-subtitle">{{ $data['title_small'] }}</span>
                            <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title mb-4">{{ $data['title_big'] }}</h2>
                            <p data-aos="fade-up" data-aos-duration="2000" class="description">
                                {!! $data['content'] !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="about-thum-wrap">
                        @if(content_exists($data['right_img']))
                        <div class="thumb">
                            <img data-aos="fade-right" data-aos-duration="1500" src="{{ asset($data['right_img']) }}" alt="about thumb not found">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <!-- About area end -->

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
