
@if(request('tab') == 'dps')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'dps'
    ])
    id="pills-dps"
    role="tabpanel"
    aria-labelledby="pills-dps-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('DPS') }}</h4>
                </div>
                <div class="site-card-body table-responsive">
                    <div class="site-table">
                        <div class="table-filter">
                            <form action="" method="get">
                                <input type="hidden" name="tab" value="dps">
                                <div class="filter d-flex">
                                    <div class="search">
                                        <label for="">{{ __('Search:') }}</label>
                                        <input type="text" name="query" value="{{ request('query') }}"/>
                                    </div>
                                    <button class="apply-btn" type="submit"><i data-lucide="search"></i>{{ __('Search') }}</button>
                                </div>
                            </form>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'DPS','field' => 'dps'])
                                @include('backend.filter.th',['label' => 'DPS ID','field' => 'dps_id'])
                                @include('backend.filter.th',['label' => 'Rate','field' => 'interest_rate'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'per_installment'])
                                <th>{{ __('Next Installment') }}</th>
                                <th>{{ __('Installments') }}</th>
                                <th>{{ __('Matured Amount') }}</th>
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($dpses as $dps)
                                <tr>
                                    <td>{{ $dps->created_at  }}</td>
                                    <td>{{ $dps->plan->name }}</td>
                                    <td>{{ $dps->dps_id }}</td>
                                    <td>{{ $dps->plan->interest_rate }}%</td>
                                    <td>
                                        {{ $currencySymbol.$dps->per_installment }}
                                    </td>
                                    <td>{{ nextInstallment($dps->id, \App\Models\DpsTransaction::class, 'dps_id') }}</td>
                                    <td>
                                        {{ $dps->plan->total_installment }}
                                    </td>
                                    <td>
                                        {{ $currencySymbol.getTotalMature($dps) }}
                                    </td>
                                    <td>
                                        @if($dps->status->value == 'running')
                                            <div class="type site-badge primary">{{ ucfirst($dps->status->value) }}</div>
                                        @elseif($dps->status->value == 'closed')
                                            <div class="type site-badge danger">{{ ucfirst($dps->status->value) }}</div>
                                        @elseif($dps->status->value == 'mature')
                                            <div class="type site-badge success">{{ ucfirst($dps->status->value) }}</div>
                                        @elseif($dps->status->value == 'due')
                                            <div class="type site-badge pending">{{ ucfirst($dps->status->value) }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found') }}!</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $dpses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
