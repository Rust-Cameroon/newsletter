@extends('frontend::layouts.user')
@section('title')
    {{ __('Referral Program') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title">{{ __('Referral Program') }}</div>
                </div>
                <div class="site-card-body">
                    <div class="referral-card">
                        <div class="row">
                            <div class="col-xl-7 col-lg-8 col-md-12">
                                <div class="title">
                                    {{ __('Earn') }} {{ $currencySymbol.setting('referral_bonus','fee') }} {{ __('after inviting one member') }}
                                </div>
                                <div class="referral-form-box">
                                    <form action="#">
                                        <input class="referral-code-input" id="refLink" type="text"
                                            value="{{ $getReferral->link }}"
                                            required />
                                        <button type="button" onclick="copyRef()" id="copyBtn">
                                            <i data-lucide="copy"></i><span>{{ __('Copy') }}</span>
                                        </button>
                                    </form>
                                    <div class="info">{{ $getReferral->relationships()->count() }} {{ __('People joined using this link.') }}</div>
                                    <a href="" class="site-btn polis-btn mt-4" data-bs-toggle="modal" data-bs-target="#shareButtons">
                                        <i data-lucide="share-2"></i>{{ __('Share URL') }}
                                    </a>
                                </div>
                                @if(is_array($rules) && setting('referral_rules_visibility'))
                                <div class="referral-rules">
                                    @foreach ($rules as $rule)
                                    <div class="single-referral-rules">
                                        @if($rule->icon == 'tick')
                                        <div class="icon check">
                                            <i data-lucide="check"></i>
                                        </div>
                                        @else
                                        <div class="icon cross">
                                            <i data-lucide="x"></i>
                                        </div>
                                        @endif

                                        <div class="contents">
                                            {{ $rule->rule }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12">
                                <img class="referral-icon" src="{{ asset('front/images/referral-icon.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Share Buttons-->
            <div class="modal fade" id="shareButtons" tabindex="-1"
                aria-labelledby="shareButtonsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-lucide="x"></i>
                            </button>
                            <div class="popup-body-text">
                                <div class="title">{{ __('Share on Social Media') }}</div>
                                <a href="http://www.facebook.com/sharer.php?u={{ $getReferral->link }}" target="_blank" class="site-btn primary-btn w-100 mb-3 centered">
                                    <i data-lucide="facebook"></i>{{ __('Facebook') }}
                                </a>
                                <a href="http://twitter.com/share?url={{ $getReferral->link }}" target="_blank" class="site-btn primary-btn w-100 mb-3 centered">
                                    <i data-lucide="twitter"></i>{{ __('Twitter') }}
                                </a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $getReferral->link }}" target="_blank" class="site-btn primary-btn w-100 mb-3 centered">
                                    <i data-lucide="linkedin"></i>{{ __('LinkedIn') }}
                                </a>

                                <div class="action-btns">
                                    <a href="" class="site-btn-sm polis-btn" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-lucide="check"></i>{{ __('Got it') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for Share Buttons end-->

            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Referred Friends') }}</div>
                    <div class="card-header-links">
                        <a href="{{ route('user.referral.tree') }}" class="card-header-link">
                            <i data-lucide="users"></i>{{ __('Referral Tree') }}
                        </a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('User') }}</div>
                                <div class="site-table-col">{{ __('Portfolio') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                            </div>

                            @foreach ($user->referrals as $user)

                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="description">
                                        <div class="event-icon">
                                            <i data-lucide="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">
                                                <a href="">{{ $user->username }}</a>
                                            </div>
                                            <div class="date">{{ $user->created_at }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-table-col">
                                    <div class="type site-badge badge-pending">{{ $user->portfolio?->portfolio_name }}</div>
                                </div>
                                <div class="site-table-col">
                                    @if($user->status == 1)
                                    <div class="type site-badge badge-primary">{{ __('Active') }}</div>
                                    @elseif($user->status == 0)
                                    <div class="type site-badge badge-warning">{{ __('Deactivated') }}</div>
                                    @else
                                    <div class="type site-badge badge-danger">{{ __('Closed') }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function copyRef() {
            /* Get the text field */
            var copyApi = document.getElementById("refLink");
            /* Select the text field */
            copyApi.select();
            /* For mobile devices */
            copyApi.setSelectionRange(0, 999999999);
            /* Copy the text inside the text field */
            document.execCommand('copy');
            $('#copyBtn>span').text('Copied!');
        }
    </script>
@endsection
