<form action="{{ request()->url() }}" method="get" id="filterForm">
    <div class="table-filter">
        <div class="filter">
            <div class="search">
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search...') }}" />
            </div>
            <button type="submit" class="apply-btn"><i data-lucide="search"></i>{{ __('Search') }}</button>
        </div>
        <div class="filter d-flex">
            <select class="form-select form-select-sm show" aria-label=".form-select-sm example" name="perPage"
                id="perPage">
                <option value="15" @selected(request('perPage')==15 )>{{ __(15) }}</option>
                <option value="30" @selected(request('perPage')==30 )>{{ __(30) }}</option>
                <option value="45" @selected(request('perPage')==45 )>{{ __(45) }}</option>
                <option value="60" @selected(request('perPage')==60 )>{{ __(60) }}</option>
            </select>
            @if(isset($button))
            <a href="{{ $route }}" class="apply-btn"><i data-lucide="settings"></i>{{ $text }}</a>
            @endif
            <div class="filter-right-btn">
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i data-lucide="filter"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Filter') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="site-input-groups mb-3">
                                        <label for="branch" class="box-input-label">{{ __('Branch') }}</label>
                                        <select class="form-select form-select-sm"
                                            name="branch" id="branch">
                                            <option value="" disabled selected>{{ __('Branch') }}</option>
                                            <option value="0" @selected(request('branch')=='all')>{{
                                                __('All') }}</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id}}" @selected(request('branch')== $branch->id)> {{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups mb-3">
                                        <label for="order" class="box-input-label">{{ __('Order') }}</label>
                                        <select class="form-select form-select-sm"
                                            name="order" id="order">
                                            <option value="asc" @selected(request('order')=='asc')>{{
                                                __('ASC') }}</option>
                                            <option value="desc" @selected(request('order')=='desc')>{{
                                                __('DESC') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn-sm primary-btn text-white mt-0">{{ __('Apply Filter')
                                            }}</button>
                                        <a href="{{ route('admin.branch.index') }}" class="btn-sm red-btn mt-0">{{
                                            __('Reset Filter') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
