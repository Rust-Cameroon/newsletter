@extends('backend.setting.index')
@section('setting-title')
    {{ __('Push Notification Settings') }}
@endsection
@section('title')
    {{ __('Notification Settings') }}
@endsection

@section('setting-content')
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="site-card">
            <div class="site-card-header d-flex">
                <h3 class="title">{{ __('Notification Tune Settings') }}</h3>

                <div class="card-header-links">
                    <a  href="{{ route('admin.settings.plugin','notification') }}" class="card-header-link new-referral" type="button" data-type="investment">
                        <i data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                </div>
            </div>
            <div class="site-card-body">
                @foreach($set_tunes as $set_tune)
                <div class="single-gateway">
                    <div class="gateway-name">
                        <div class="gateway-icon">
                            <img
                                src="{{ asset($set_tune->icon) }}" alt=""/>
                        </div>
                        <div class="gateway-title">
                            <h4>{{ $set_tune->name }}</h4>
                        </div>
                    </div>
                    <div class="gateway-right">
                        <div class="gateway-status m-0 me-2">
                            <button type="button" value="{{ $set_tune->id }}" data-tune-preview="{{ asset($set_tune->tune) }}" class="site-btn-xs primary-btn audioPlay">
                               <span class="play-{{$set_tune->id}} play"> <i class="play" data-lucide="play"></i></span>
                               <span class="stop-{{$set_tune->id}} hidden stop"> <i data-lucide="pause"></i></span>
                                <span class="tune-status-{{$set_tune->id}} status-text">{{ __('Play') }}</span>
                            </button>
                        </div>
                        <div class="gateway-status m-0">
                            @if($set_tune->status == true)
                                <a href="{{ route('admin.settings.notification.tune.status', $set_tune->id) }}" class="site-btn-xs green-btn"><i data-lucide="check"></i>{{ __('Active in') }}</a>
                            @else
                                <a href="{{ route('admin.settings.notification.tune.status', $set_tune->id) }}" class="site-btn-xs red-btn"><i data-lucide="x"></i>{{ __('Inactive') }}</a>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>
    (function ($) {
        'use strict';
    var audio;
    var isPlaying = false;
    var oldTuneSrc = null
    $('.audioPlay').on('click', function (e) {
         e.preventDefault();
        var id = $(this).val();
        $('.stop').addClass('hidden');
        $('.play').removeClass('hidden');

        let tunePreview = $(this).data('tune-preview');
        var tuneStatus = $('.tune-status-'+$(this).val());
        var status = tuneStatus.text();

        if (status === 'Play') {
            if (isPlaying && tunePreview === oldTuneSrc) {
                $('.play-'+$(this).val()).addClass('hidden');
                $('.stop-'+$(this).val()).removeClass('hidden');
                tuneStatus.text('Stop');
                audio.pause();
                audio.currentTime = 0;

            }else {
                $('.play-'+$(this).val()).addClass('hidden');
                $('.stop-'+$(this).val()).removeClass('hidden');

                $('.status-text').text('Play');
                tuneStatus.text('Stop');

                if (audio) {
                    audio.pause();
                    audio.currentTime = 0;
                }
                audio = new Audio(tunePreview);

                $(audio).on('ended', function() {
                    tuneStatus.text('Play');
                    $('.play-'+id).removeClass('hidden');
                    $('.stop-'+id).addClass('hidden');
                    isPlaying = false;
                });

                audio.play();
                isPlaying = true;
                oldTuneSrc = tunePreview
            }

        } else if (status === 'Stop') {
            $('.play-'+$(this).val()).removeClass('hidden');
            $('.stop-'+$(this).val()).addClass('hidden');
            audio.pause();
            audio.currentTime = 0;
            tuneStatus.text('Play');
            isPlaying = false;
        }
    })

    })(jQuery)
</script>

@endsection

