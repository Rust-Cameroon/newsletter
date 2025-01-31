<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="user-ranking" @if($user->avatar) style="background: url({{ asset($user->avatar) }});" @endif>
            <h4>{{ $user->portfolio->level }}</h4>
            <p>{{ $user->portfolio->portfolio_name }}</p>
            <div class="rank" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->portfolio->description }}">
                <img src="{{ asset( $user->portfolio->icon) }}" alt="">
            </div>
        </div>
    </div>
    @if(setting('sign_up_referral','permission'))
        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Referral URL') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="referral-link">
                        <div class="referral-link-form">
                            <input type="text" value="{{ $referral->link }}" id="refLink"/>
                            <button type="submit" onclick="copyRef()">
                                <i class="anticon anticon-copy"></i>
                                <span id="copy">{{ __('Copy') }}</span>
                            </button>
                        </div>
                        <p class="referral-joined">
                            {{ $referral->relationships()->count() }} {{ __('peoples are joined by using this URL') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
