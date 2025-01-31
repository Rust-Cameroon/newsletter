<script>
    (function ($) {
        'use strict';

        let pusherAppKey = "{{ config('broadcasting.connections.pusher.key') }}";
        let pusherAppCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
        let soundUrl = "{{ route('notification-tune') }}";

        var notification = new Pusher(pusherAppKey, {
            encrypted: true,
            cluster: pusherAppCluster,
        });
        var channel = notification.subscribe('{{ $for }}-notification{{$userId}}');
        channel.bind('notification-event', function (result) {
            playSound();
            latestNotification();
            notifyToast(result);
        });

        function latestNotification() {
            $.get('{{ route($for.'.latest-notification')}}', function (data) {
                $('.{{ $for }}-notifications{{$userId}}').html(data);
            })
        }

        function notifyToast(data) {
            new Notify({
                status: 'info',
                title: data.data.title,
                text: data.data.notice,
                effect: 'slide',
                speed: 300,
                customClass: '',
                customIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone"><path d="m3 11 18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>',
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 9000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right bottom',
                customWrapper: '<div><a href="' + data.data.action_url + '" class="learn-more-link">Explore<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="external-link" class="lucide lucide-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg></a></div>',
            })

        }

        function playSound() {
            $.get(soundUrl, function (data) {
                var audio = new Audio(data);
                audio.play();
                audio.muted = false;
            });
        }

    })(jQuery);
</script>
