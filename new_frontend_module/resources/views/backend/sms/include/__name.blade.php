@section('style')
    <style>
        .site-table .table tbody tr td .table-description {
            display: flex;
            align-items: center;
        }
        .site-table .table tbody tr td .table-description .icon {
            height: 45px;
            width: 45px;
            line-height: 42px;
            border-radius: 50%;
            background: rgba(94, 63, 201, 0.2);
            color: #5e3fc9;
            text-align: center;
            margin-right: 15px;
        }
        .site-table .table tbody tr td .table-description .description {
            line-height: 1.6;
        }
    </style>
@endsection
<div class="table-description">
    <div class="icon">
        <i data-lucide="message-square"></i>
    </div> 
    <div class="description">
        <strong>{{ $name }}</strong>
        <div class="date fst-italic">{{ $for }}</div>
    </div>
</div>
<script>
    'use strict';
    lucide.createIcons();
</script>
