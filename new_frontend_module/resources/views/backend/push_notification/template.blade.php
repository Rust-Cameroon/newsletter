@extends('backend.layouts.app')
@section('title')
    {{ __('Push Notification Template') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Push Notification Template') }}</h2>
                            <a href="{{ route('admin.settings.plugin','notification') }}" class="title-btn"><i
                                    data-lucide="mail"></i>{{ __('Push Notification Config') }}</a>
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
                            @include('backend.push_notification.include.__filter', ['status' => true])
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('Notification For') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($notifications as $notification)
                                    <tr>
                                        <td>
                                            @include('backend.push_notification.include.__name', ['name' => $notification->name, 'for' => $notification->for, 'icon' => $notification->icon])
                                        </td>
                                        <td>
                                            @include('backend.push_notification.include.__status', ['status' => $notification->status])
                                        </td>
                                        <td>
                                            @include('backend.push_notification.include.__action', ['id' => $notification->id])
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="3" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                                </tbody>
                            </table>

                            {{ $notifications->links('backend.include.__pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


