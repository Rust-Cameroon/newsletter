@extends('backend.layouts.app')
@section('title')
    {{ __($statusForFrontend.' DPS') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __($statusForFrontend.' DPS') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.dps.include.__filter', ['status' => false, 'type' => false ])
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Plan','field' => 'plan'])
                                @include('backend.filter.th',['label' => 'User','field' => 'user'])
                                @include('backend.filter.th',['label' => 'DPS ID','field' => 'dps_id'])
                                @include('backend.filter.th',['label' => 'Given','field' => 'given_installment'])
                                <th>{{ __('Next Installment') }}</th>
                                <th>{{ __('After Maturity') }}</th>
                                @include('backend.filter.th',['label' => 'Open At','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dpses as $dps)
                                <tr>
                                    <td>
                                        {{ $dps->plan->name }}
                                    </td>
                                    <td>
                                        @include('backend.dps.include.__user', ['id' => $dps->user_id, 'name' => $dps->user->username])
                                    </td>
                                    <td>{{ safe($dps->dps_id) }}</td>
                                    <td>
                                        {{ safe($dps->given_installment) }}
                                    </td>
                                    <td>
                                        {{ nextInstallment($dps->id, \App\Models\DpsTransaction::class, 'dps_id') }}
                                    </td>
                                    <td>
                                        {{ $currencySymbol.getTotalMature($dps) }}
                                    </td>
                                    <td>
                                        {{ safe($dps->created_at) }}
                                    </td>
                                    <td>
                                        @include('backend.dps.include.__dps_status', ['status' => $dps->status->value])
                                    </td>
                                    <td>
                                        @include('backend.dps.include.__action', ['id' => $dps->id])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="10" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $dpses->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
