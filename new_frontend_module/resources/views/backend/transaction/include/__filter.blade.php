@section('style')
    <style>
        .apply-btn-filter {
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
@endsection
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
            @if(isset($status) && $status == true)
                <select
                    class="form-select form-select-sm"
                    aria-label=".form-select-sm example"
                    name="status"
                    id="status"
                >
                    <option value="" disabled selected>{{ __('Status') }}</option>
                    <option value="all" @selected(request('status') == 'all')>{{ __('All') }}</option>
                    <option value="success" @selected(request('status') == 'success')>{{ __('Success') }}</option>
                    <option value="pending" @selected(request('status') == 'pending')>{{ __('Pending') }}</option>
                    <option value="failed" @selected(request('status') == 'failed')>{{ __('Failed') }}</option>
                </select>
            @endif
            @if(isset($type) && $type == true)
                @php
                    $reflectionClass = new ReflectionClass(\App\Enums\TxnType::class);
                    $txnType = $reflectionClass->getConstants();
                @endphp
                <select
                    class="form-select form-select-sm"
                    aria-label=".form-select-sm example"
                    name="type"
                    id="type"
                >
                    <option value="" disabled selected>{{ __('Type') }}</option>
                    <option value="all" @selected(request('type') == 'all')>{{ __('All') }}</option>
                    @foreach($txnType as $key => $value)
                        <option value="{{ $value }}" @selected(trim(request('type')) === trim($value->value))>{{ $key }}</option>
                    @endforeach
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

            $('#type').on('change', function() {
                $('#filterForm').submit();
            });
        })(jQuery);

    </script>
@endpush
