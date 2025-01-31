@extends('frontend::layouts.user')
@section('title')
    {{ __('Fund Transfer') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="transaction-success-block success">
                <div class="icon"><i data-lucide="check-circle"></i></div>
                <div class="headding">{{$responseData['currency']}}{{$responseData['amount']}} {{ $message }}</div>
                <div class="text">{{ __('The amount is sent to') }} <strong>{{ $responseData['account'] }}</strong></div>
                <div class="trx">{{ __('Transaction ID:') }} {{ $responseData['tnx'] }}</div>
                <a href="{{ route('user.fund_transfer.index') }}" class="site-btn polis-btn">
                    {{ __('Transfer Again') }}
                </a>
            </div>
        </div>
    </div>
@endsection
