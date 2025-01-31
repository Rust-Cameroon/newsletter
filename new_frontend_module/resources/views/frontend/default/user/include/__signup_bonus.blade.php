<div id="auto-popup" class="auto-popup-section">
    <div class="auto-popup-dialog animated fadeInUp">
        <button class="auto-popup-close auto-popup-close-now"><i data-lucide="x"></i></button>
        <div class="auto-popup-dialog-inner"
             style="background: url({{ asset('frontend/images/auto-pop.jpg') }}) no-repeat;">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="auto-pop-content">
                        <h2>{{ __('Congratulation!') }}</h2>
                        <h3>{{ __('You got a Signup Bonus') }}
                            <span>{{ Session::get('signup_bonus') }} {{ $currency }}</span></h3>
                        <button class="site-btn grad-btn auto-popup-close-now"><i
                                class="anticon anticon-check"></i> {{ __('Got it') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php Session::remove('signup_bonus'); @endphp

@push('script')
    <script>
        'use strict';
        // Auto Popup
        $('.auto-popup-close-now').on('click', function () {
            var $this = $(this),
                $popup = $this.closest('#auto-popup'),
                $dialog = $this.parent('.auto-popup-dialog');
            $popup.addClass('close');
            $dialog.removeClass('fadeInUp').addClass('fadeOutUp');
        });
    </script>
@endpush
