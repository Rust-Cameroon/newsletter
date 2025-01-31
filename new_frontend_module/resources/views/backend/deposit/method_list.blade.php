@extends('backend.deposit.index')
@section('title')
    {{ __(ucwords($type).' Deposit Method') }}
@endsection
@section('deposit_content')
    <div class="col-xl-12 col-md-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Setup Payment Methods') }}</h3>
            </div>
            <div class="site-card-body">
                <p class="paragraph">
                    {{ __(' All the ') }}
                    <strong>{{ __('Deposit Payment Methods') }}</strong> {{ __('Setup for user') }}
                </p>
                @forelse($depositMethods as $method)
                    <div class="single-gateway">
                        <div class="gateway-name">
                            <div class="gateway-icon">
                                <img
                                    src="{{ asset($method->logo ?? $method->gateway->logo) }}"
                                    alt=""
                                />
                                <span class="icon-currency-type">{{ $method->currency }}</span>
                            </div>
                            <div class="gateway-title">
                                <h4>{{$method->name}}</h4>
                                <p>{{ __('Minimum Deposit: ').$method->minimum_deposit .' '. $currency }}</p>
                            </div>
                        </div>
                        <div class="gateway-right">
                            <div class="gateway-status">
                                @if($method->status)
                                    <div class="site-badge success">{{ __('Activated') }}</div>
                                @else
                                    <div class="site-badge pending">{{ __('Deactivated') }}</div>
                                @endif
                            </div>
                            <div class="gateway-edit">
                                <a href="{{ route('admin.deposit.method.edit',['type' => strtolower($type),'id' => $method->id]) }}"><i
                                        data-lucide="settings-2"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="text-center">{{ __('No Data Found!') }}</div>
                @endforelse

            </div>

        </div>
    </div>
@endsection
