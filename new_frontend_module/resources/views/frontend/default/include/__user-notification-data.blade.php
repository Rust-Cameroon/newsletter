<button type="button" class="item notification-dot" data-bs-toggle="dropdown" aria-expanded="false">
    <i data-lucide="bell" @class(['bell-ringng' => $totalUnread > 0])></i>
    <div class="number">{{ $totalUnread }}</div>
</button>
<div class="dropdown-menu dropdown-menu-end notification-pop">
    <div class="noti-head">{{ __('Notifiactions') }} <span>{{ $totalUnread }}</span></div>
    <div class="all-noti">
        @foreach($notifications as $notification)
        <div class="single-noti">
            <a href="{{ route($notification->for.'.read-notification', $notification->id) }}" @class(['read' => $notification->read ])>
                <div class="icon">
                    <i data-lucide="{{ $notification->icon }}"></i>
                </div>
                <div class="content">
                    <div class="main-cont">{{ $notification->title }}</div>
                    <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
            </a>
        </div>
        @endforeach
        @if($totalCount == 0)
            <p class="text-center">{{ __('Notification Not Found') }}</p>
        @endif
    </div>
    @if($totalCount != 0)
    <div class="noti-footer mt-3">
        @if($totalUnread > 0)
        <a class="noti-btn-1 me-1 w-100" href="{{ route($notifications->first()->for.'.read-notification', 0) }}">Mark All as Read</a>
        @endif
        <a class="noti-btn-2 ms-1 w-100" href="{{ route($notifications->first()->for.'.notification.all') }}">See all notifications</a>
    </div>
    @endif
</div>
