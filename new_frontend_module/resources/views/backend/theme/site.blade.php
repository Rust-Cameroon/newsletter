@extends('backend.theme.index')
@section('theme-title')
    {{ __('Site Themes') }}
@endsection
@section('theme-content')

    @foreach($themes as $theme)
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ ucwords( str_replace('_', ' ',$theme->name) ) }} {{ __('Theme') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="theme-img">
                        @if($theme->status)
                            <div class="activated">{{ __('Activated') }}</div>
                        @endif
                        <img class="w-100" src="{{ asset('backend/materials/theme/'.$theme->name . '.jpg') }}" alt="">
                    </div>
                    @if($theme->status)
                        <a href="#" class="site-btn w-100 centered mt-4 disabled"><i data-lucide="circle-check"></i>{{ __('Activated') }}</a>
                    @else
                        <a href="{{ route('admin.theme.status-update',['id' => $theme->id]) }}" class="site-btn black-btn w-100 centered mt-4"><i data-lucide="check"></i>{{ __('Active Now') }}</a>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
@endsection
