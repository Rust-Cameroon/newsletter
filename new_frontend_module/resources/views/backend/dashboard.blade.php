@php use App\Enums\InvestStatus; @endphp
@extends('backend.layouts.app')
@section('title')
    {{ __('Admin Dashboard') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ setting('site_title', 'global') }} {{ __('Dashboard') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <div class="row">
                @include('backend.include.__action')
                @include('backend.include.__data_card')
                @can('site-statistics-chart')
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="site-chart">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Site Statistics') }}</h3>
                                <div class="card-header-links">
                                    <input class="card-header-input" type="text" name="site_daterange" value="{{ $data['start_date'] .' - '. $data['end_date'] }}" />
                                </div>
                            </div>
                            <div class="site-card-body">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('fund-transfer-statistics')
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="site-chart">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Fund Transfer Statistics') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <canvas id="fundTransferChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('top-country-statistics')
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="site-chart">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Top Country Statistics') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <canvas id="countryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('top-browser-statistics')
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="site-chart">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Top Browser Statistics') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <canvas id="browserChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('top-os-statistics')
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="site-chart">
                        <div class="site-card">
                            <div class="site-card-header">
                                <h3 class="title">{{ __('Top OS Statistics') }}</h3>
                            </div>
                            <div class="site-card-body">
                                <canvas id="osChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('latest-users')
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Latest Users') }}</h3>
                        </div>
                        <div class="site-card-body table-responsive">
                            <div class="site-datatable">
                                <table class="data-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Avatar') }}</th>
                                        <th>{{ __('User') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Balance') }}</th>
                                        <th>{{ __('KYC') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['latest_user'] as $user)
                                        <tr>
                                            <td>
                                                @include('backend.user.include.__avatar', ['avatar' => $user->avatar, 'first_name' => $user->first_name, 'last_name' => $user->last_name])
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.user.edit',$user->id) }}"
                                                   class="link">{{ Str::limit($user->username,15) }}
                                                </a>
                                            </td>
                                            <td>
                                                <strong>{{ Str::limit($user->email,20) }}</strong>
                                            </td>
                                            <td><strong>{{ $currencySymbol . $user->balance }}</strong></td>
                                            <td>
                                                @if($user->kyc == 1)
                                                    <div class="site-badge success">{{ __('Verified') }}</div>
                                                @else
                                                    <div class="site-badge pending">{{ __('Unverified') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->status == 1)
                                                    <div class="site-badge success">{{ __('Active') }}</div>
                                                @else
                                                    <div class="site-badge danger">{{ __('DeActivated') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @include('backend.user.include.__action', ['user' => $user,'delete_hidden' => true])
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="centered">
                                        <td colspan="7">
                                            @if($data['latest_user']->isEmpty())
                                                {{ __('No Data Found') }}
                                            @endif
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                @endcan

            </div>

        </div>
    </div>
    <!-- Modal for Send Email -->
    @include('backend.user.include.__mail_send')
    <!-- Modal for Send Email-->

@endsection
@section('script')
    @include('backend.include.__chartjs')
    <script>
        (function ($) {
            'use strict'
            //send mail modal form open
            $('body').on('click', '.send-mail', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#name').html(name);
                $('#userId').val(id);
                $('#sendEmail').modal('toggle')
            })

            // Delete
            $('body').on('click', '#deleteModal', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#data-name').html(name);
                var url = '{{ route("admin.user.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteForm').attr('action', url);
                $('#delete').modal('toggle')

            });
        })(jQuery)
    </script>
@endsection
