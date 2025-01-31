<form action="{{ request()->url() }}" method="get" id="filterForm">
    <div class="table-filter">
        <div class="filter">
            <div class="search">
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search..." />
            </div>
            <button type="submit" class="apply-btn"><i data-lucide="search"></i>Search</button>
        </div>
        <div class="filter d-flex">

            <select class="form-select form-select-sm show" aria-label=".form-select-sm example" name="perPage"
                id="perPage">
                <option value="15" {{ request('perPage')==15 ? 'selected' : '' }}>15</option>
                <option value="30" {{ request('perPage')==30 ? 'selected' : '' }}>30</option>
                <option value="45" {{ request('perPage')==45 ? 'selected' : '' }}>45</option>
                <option value="60" {{ request('perPage')==60 ? 'selected' : '' }}>60</option>
            </select>
            @if(isset($status) && $status == true)
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="status" id="status">
                <option value="" disabled selected>{{ __('Select Status') }}</option>
                <option value="all" {{ request('status')=='all' ? 'selected' : '' }}>{{ __('All') }}</option>
                <option value="success" {{ request('status')=='success' ? 'selected' : '' }}>{{ __('Success') }}</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="failed" {{ request('status')=='failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
            </select>
            @endif

            @if($type == true)
            @php
            $reflectionClass = new ReflectionClass(\App\Enums\TransferType::class);
            $txnType = $reflectionClass->getConstants();
            @endphp
            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="type" id="type">
                <option value="" disabled selected>{{ __('Type') }}</option>
                <option value="all" {{ request('type')=='all' ? 'selected' : '' }}>All</option>
                @foreach($txnType as $key => $value)
                <option value="{{ $value }}" {{ trim(request('type'))===trim($value->value) ? 'selected' : '' }}>{{ $key }}
                </option>
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
    })(jQuery);
</script>
@endpush
