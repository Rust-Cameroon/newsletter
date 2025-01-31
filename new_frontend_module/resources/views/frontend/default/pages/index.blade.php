@extends('frontend::layouts.app')
@section('content')
    <section class="breadcrumb-area style-one position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-9 col-xl-9 col-lg-10">
                    <div class="breadcrumb-content-wrapper">
                        <div class="breadcrumb-content text-center">
                            <h1 class="title">@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-shapes">
            <div class="shape-one">
                <img src="{{ asset(getPageSetting('shape_one')) }}" alt="shape not found">
            </div>
            <div class="shape-two">
                <img src="{{ asset(getPageSetting('shape_two')) }}" alt="shape not found">
            </div>
            <div class="shape-three">
                <img src="{{ asset(getPageSetting('shape_three')) }}" alt="shape not found">
            </div>
        </div>
    </section>

    @yield('page-content')

@endsection
