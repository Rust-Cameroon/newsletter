@extends('frontend::layouts.user')
@section('title')
    {{ __('All Notifications') }}
@endsection
@section('content')
    <div class="row">
        @include('frontend::user.setting.include.__settings_nav')
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('All Notifications') }}</h3>
                </div>
                <div class="site-card-body">
                    <div class="notification-list">
                        @forelse($notifications as $notification)
                            <div @class(['single-list', 'read' => $notification->read ])>
                                <div class="cont">
                                    <div class="icon"><i data-lucide="{{ $notification->icon }}"></i></div>
                                    <div class="contents">
                                        {{ $notification->title }}
                                        <div class="time"> {{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="link">
                                    <a href="{{ route('user.read-notification', $notification->id) }}"
                                       class="red-btn"><i data-lucide="external-link"></i>{{ __('Explore') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                        <div class="text-center">{{ __('No Data Found!') }}</div>
                        @endforelse
                    </div>
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
