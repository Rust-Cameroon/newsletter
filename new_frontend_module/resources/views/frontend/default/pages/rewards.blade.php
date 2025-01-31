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
    $redeems = App\Models\RewardPointRedeem::with('portfolio')->get();
    $transactions = App\Models\RewardPointEarning::with('portfolio')->get();
@endphp

    <!-- Rewards card area start -->
    <section class="rewards-card-area position-relative fix section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8">
                    <div class="section-title-wrapper text-center section-title-space">
                        <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['title_one'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="rewards-card-grid">
                    @foreach ($redeems as $redeem)
                    <div class="rewards-card-item">
                        <div class="shape-one">
                            <img src="{{ asset('front/images/shapes/rewards-shape-01.svg') }}" alt="">
                        </div>
                        <div class="shape-two">
                            <img src="{{ asset('front/images/shapes/rewards-shape-02.svg') }}" alt="">
                        </div>
                        <div class="content-inner">
                            <div class="content">
                                <h3 class="title">{{ $redeem->portfolio?->portfolio_name }}</h3>
                            </div>
                            <div class="icon">
                                <span><img src="{{ asset($redeem->portfolio?->icon) }}" alt=""></span>
                            </div>
                        </div>
                        <div class="btn-inner">
                            <a class="site-btn" href="{{ route('user.rewards.index') }}">{{ __('Redeem Now') }}</a>
                            <div class="card-point">
                                <span>{{ $redeem->point }} {{ __('Points') }} = {{ $redeem->amount }} {{ $currency }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Rewards card area end -->

    <!-- Rewards point area start -->
    <section class="rewards-point-area whiteSmoke-bg position-relative fix section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8">
                    <div class="section-title-wrapper text-center section-title-space">
                        <h2 data-aos="fade-up" data-aos-duration="1500" class="section-title">{{ $data['title_two'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-30 justify-content-center" data-aos="fade-up" data-aos-duration="2000">
                <div class="col-lg-6">
                    <div class="rewards-point-item">
                        <div class="reward-table table-responsive">
                           <table class="table">
                              <thead>
                                 <tr>
                                      <th>{{ __('Portfolio List') }}</th>
                                      <th>{{ __('Per Transactions') }}</th>
                                      <th>{{ __('Points') }}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                  @foreach ($transactions as $item)
                                  <tr>
                                      <td>{{ $item->portfolio->portfolio_name }}</td>
                                      <td>{{ $currencySymbol.$item->amount_of_transactions }}</td>
                                      <td>{{ $item->point }} {{ __('Points') }}</td>
                                  </tr>
                                  @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Rewards point area end -->
@endsection
