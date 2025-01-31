@extends('backend.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title"> @yield('title')</h2>
                            @isset($button)
                                <a href="{{$button['route']}}"
                                   class="title-btn"
                                   type="button"
                                ><i data-lucide="{{$button['icon']}}"></i>{{$button['name']}}</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-tab-bars">
                        <ul>

                            @can('automatic-gateway-manage')
                                <li class="{{ isActive('admin.deposit.method.list','auto') . isActive('admin.deposit.method.create','auto'). isActive('admin.deposit.method.edit','auto')  }}">
                                    <a href="{{ route('admin.deposit.method.list','auto') }}"><i
                                            data-lucide="settings-2"></i>{{ __('Automatic Method') }}</a>
                                </li>
                            @endcan

                            @can('manual-gateway-manage')
                                <li class="{{ isActive('admin.deposit.method.list','manual') . isActive('admin.deposit.method.create','manual') . isActive('admin.deposit.method.edit','manual') }}">
                                    <a href="{{ route('admin.deposit.method.list','manual') }}"><i
                                            data-lucide="book-open"></i>{{ __('Manual Method') }}</a>
                                </li>
                            @endcan
                            @canany(['deposit-list','deposit-action'])
                                <li class="{{ isActive('admin.deposit.manual.pending') }}">
                                    <a href="{{ route('admin.deposit.manual.pending') }}"><i
                                            data-lucide="box"></i>{{ __('Manual Pending Deposit') }}</a>
                                </li>
                                <li class="{{ isActive('admin.deposit.history') }}">
                                    <a href="{{ route('admin.deposit.history') }}"><i
                                            data-lucide="calendar"></i>{{ __('Deposit History') }}</a>
                                </li>
                            @endcanany
                        </ul>
                    </div>
                    <div class="row">
                        @yield('deposit_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
