@extends('frontend::layouts.user')
@section('title')
    {{ __('Portfolios') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Your Portfolios') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="row justify-content-center">
                        @forelse($portfolios as $portfolio)
                        @php
                            $isUnlocked = in_array($portfolio->id,$alreadyPortfolio);
                        @endphp
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="single-badge @if($isUnlocked) unlocked @endif">
                                @if($isUnlocked)
                                <div class="tick-badge">
                                    <i data-lucide="check"></i>
                                </div>
                                @endif
                                <div class="badge">
                                    <div class="img">
                                        <img src="{{ asset($portfolio->icon) }}" alt="" />
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{ $portfolio->portfolio_name }}</h3>
                                    <p class="description">
                                        {{ $portfolio->description }}`
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">{{ __('No Data Found!') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

