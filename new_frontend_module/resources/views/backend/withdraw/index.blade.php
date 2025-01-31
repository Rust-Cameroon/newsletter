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
                                <a href="{{ $button['route']}}"
                                   class="title-btn"
                                   type="button"
                                ><i data-lucide="{{ $button['icon']}}"></i>{{ $button['name']}}</a>
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
                            @can('withdraw-list')
                                <li class="{{ isActive('admin.withdraw.pending') }}">
                                    <a href="{{ route('admin.withdraw.pending') }}"><i
                                            data-lucide="anchor"></i>{{ __('Pending Withdraws') }}</a>
                                </li>
                            @endcan
                            @can('withdraw-method-manage')

                                <li class="{{ isActive('admin.withdraw.method.list','auto') . isActive('admin.withdraw.method.create','auto'). isActive('admin.withdraw.method.edit','auto')  }}">
                                    <a href="{{ route('admin.withdraw.method.list','auto') }}"><i
                                            data-lucide="banknote"></i>{{ __('Automatic Method') }}</a>
                                </li>

                                <li class="{{ isActive('admin.withdraw.method.list','manual') . isActive('admin.withdraw.method.create','manual') . isActive('admin.withdraw.method.edit','manual') }}">
                                    <a href="{{ route('admin.withdraw.method.list','manual') }}"><i
                                            data-lucide="landmark"></i>{{ __('Manual Method') }}</a>
                                </li>
                            @endcan
                            @can('withdraw-schedule')
                                <li class="{{ isActive('admin.withdraw.schedule') }}">
                                    <a href="{{ route('admin.withdraw.schedule') }}"><i
                                            data-lucide="alarm-clock"></i>{{ __('Withdraw Schedule') }}</a>
                                </li>
                            @endcan
                            @can('withdraw-list')
                                <li class="{{ isActive('admin.withdraw.history') }}">
                                    <a href="{{ route('admin.withdraw.history') }}"><i
                                            data-lucide="calendar"></i>{{ __('Withdraw History') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                    <div class="row">
                        @yield('withdraw_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
