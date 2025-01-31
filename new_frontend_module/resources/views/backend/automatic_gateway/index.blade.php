@extends('backend.layouts.app')
@section('title')
    {{ __('Automatic Payment Gateway') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Automatic Payment Gateway') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        <form action="{{ request()->url() }}" method="get" id="filterForm">
                            <div class="table-filter">
                                <div class="filter">
                                    <div class="search">
                                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}"/>
                                    </div>
                                    <button type="submit" class="apply-btn"><i data-lucide="search"></i>{{ __('Search') }}</button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Logo') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Supported Currency') }}</th>
                                <th>{{ __('Withdraw Available') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Manage') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gateways as $gateway)
                                <tr>
                                    <td>
                                        <img height="25" src="{{  asset($gateway->logo) }}" alt="">
                                    </td>
                                    <td>{{ $gateway->name }}</td>
                                    <td> {{ count(json_decode($gateway->supported_currencies,true)) }}</td>
                                    <td>
                                        @if($gateway->is_withdraw != 0)
                                            <div class="site-badge success"> {{ __('Yes') }}</div>
                                        @else
                                            <div class="site-badge pending">  {{ __('No') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($gateway->status == 1)
                                            <div class="site-badge success"> {{ __('Activated') }}</div>
                                        @else
                                            <div class="site-badge pending">  {{ __('Deactivated') }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        <button
                                            class="round-icon-btn primary-btn"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#manage-{{$gateway->id}}"
                                        >
                                            <i data-lucide="settings-2"></i>
                                        </button>
                                    </td>
                                </tr>


                                <!--  Manage Modal -->
                                @include('backend.automatic_gateway.include.__manage')
                                <!-- Manage Modal End-->

                            @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
