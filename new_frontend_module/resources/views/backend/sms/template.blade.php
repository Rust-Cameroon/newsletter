@extends('backend.layouts.app')
@section('title')
    {{ __('SMS Template') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('SMS Template') }}</h2>
                            <a href="{{ route('admin.settings.plugin','sms') }}" class="title-btn"><i
                                    data-lucide="mail"></i>{{ __('SMS Config') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card-body table-responsive">
                        <div class="site-table table-responsive">
                            @include('backend.sms.include.__filter', ['status' => true])
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('SMS For') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($sms as $val)
                                    <tr>
                                        <td>
                                            @include('backend.sms.include.__name', ['name' => $val->name, 'for' => $val->for])
                                        </td>
                                        <td>
                                            @include('backend.sms.include.__status', ['status' => $val->status])
                                        </td>
                                        <td>
                                            @include('backend.sms.include.__action', ['id' => $val->id])
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="3" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                                </tbody>
                            </table>

                            {{ $sms->links('backend.include.__pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


