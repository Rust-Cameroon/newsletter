<div class="table-description">
    <div class="icon">
        <i data-lucide="@switch($type)
            @case('send_money')arrow-right
            @break
            @case('receive_money')arrow-left
            @break
            @case('deposit')arrow-down-left
            @break
            @case('manual_deposit')arrow-down-left
            @break
            @case('investment')arrow-left-right
            @break
            @case('withdraw')arrow-up-left
            @break
            @default()backpack
        @endswitch">
        </i>
    </div>
    <div class="description">
        <strong>{{$description}}</strong>@if(!in_array($approval_cause,['none',""]))
            <span class="optional-msg" data-bs-toggle="tooltip" title="" data-bs-original-title="{{ $approval_cause }}"><i
                    data-lucide="mail"></i></span>
        @endif
        <div class="date">{{ $created_at }}</div>
    </div>
</div>
<script>
    'use strict';
    lucide.createIcons()
    $(document).ajaxComplete(function () {
        $('[data-bs-toggle="tooltip"]').tooltip({
            "html": true,
        });
    });
</script>
