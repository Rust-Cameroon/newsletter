@extends('frontend::user.dashboard')

@section('user-dashboard-content')

    <div class="card">
        <div class="card-header">
            {{$gateway->name}} {{ __('Payment') }}
        </div>
        <div class="card-body">
            <div class="site-form mb-30">
                <form role="form" action="{{ route('gateway.manual') }}" method="POST">
                    @csrf

                    <input type="hidden" name="transaction_id" value="{{$transactionID}}">

                    <div class="profile-card-body">
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="thumb text-right">
                                    <img src="{{ asset($gateway->logo)  }}" alt="">
                                </div>
                            </div>
                            <div class="thumb text-left">
                                <h4>{{$gateway->name}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-3">
                                <div class="left-info text-right">
                                    @foreach(json_decode($gateway->credentials,true) as $key => $value)
                                        <p>{{$key}}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-9 col-9">
                                <div class="right-info">
                                    @foreach(json_decode($gateway->credentials,true) as $key => $value)
                                        <p>{{$value}}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-sm-12 mb-10">
                            <label for="card-holder-name">{{ __('Transaction Id') }}</label>
                            <input type="text" name="prof_transaction" required>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <button type="submit" class="bttn-mid btn-fill">{{ __('Confirm Now') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

