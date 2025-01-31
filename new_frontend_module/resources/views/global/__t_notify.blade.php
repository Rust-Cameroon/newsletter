@if(session('tnotify'))
    <script>
        (function ($) {
            'use strict';
            let message = '{{ session('tnotify')['message'] }}';
            let type = '{{ session('tnotify')['type'] }}';
            tNotify(type, message);
        })(jQuery);
    </script>
@endif
