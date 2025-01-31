@section('style')
    <style>
        .site-table .table-filter .filter .apply-btn-filter {
            display: inline-block;
            background: #5e3fc9 !important;
            border-radius: 3px;
            padding: 8px 20px;
            border: none;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            min-width: 116px;
            margin-top: 10px;
        }
    </style>
@endsection()
<form action="{{ request()->url() }}" method="get" id="filterForm">
<div class="table-filter">
    <div class="filter">
        <div class="search">
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search..."/>
        </div>
        <button type="submit" class="apply-btn"><i data-lucide="search"></i>Search</button>
    </div>
    <div class="filter d-flex">

        <select
            class="form-select form-select-sm show"
            aria-label=".form-select-sm example"
            name="perPage"
            id="perPage"
        >
            <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30</option>
            <option value="45" {{ request('perPage') == 45 ? 'selected' : '' }}>45</option>
            <option value="60" {{ request('perPage') == 60 ? 'selected' : '' }}>60</option>
        </select>
        @if($status)
        <select
            class="form-select form-select-sm"
            aria-label=".form-select-sm example"
            name="status"
            id="status"
        >
            <option value="" disabled selected>{{ __('Select Status') }}</option>
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>{{ __('Verified') }}</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
        </select>
        @endif
    </div>
</div>
</form>
@push('single-script')
    <script>
        (function ($) {
            "use strict";
            $('#perPage').on('change', function() {
                $('#filterForm').submit();
            });

            $('#order').on('change', function() {
                $('#filterForm').submit();
            });
            $('#status').on('change', function() {
                $('#filterForm').submit();
            });
        })(jQuery);

    </script>
@endpush
