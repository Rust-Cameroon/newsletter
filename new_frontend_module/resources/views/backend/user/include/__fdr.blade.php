@if(request('tab') == 'fdr')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'fdr'
    ])
    id="pills-fdr"
    role="tabpanel"
    aria-labelledby="pills-fdr-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('FDR') }}</h4>
                </div>
                <div class="site-card-body table-responsive">
                    <div class="site-table">
                        <div class="table-filter">
                            <form action="" method="get">
                                <input type="hidden" name="tab" value="fdr">
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
                                @include('backend.filter.th',['label' => 'FDR','field' => 'fdr'])
                                @include('backend.filter.th',['label' => 'FDR ID','field' => 'fdr_id'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'amount'])
                                <th>{{ __('Profit') }}</th>
                                <th>{{ __('Next Receive') }}</th>
                                <th>{{ __('Returns') }}</th>
                                <th>{{ __('Paid') }}</th>
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($fdres as $fdr)
                                <tr>
                                    <td>{{ $fdr->created_at->format('d M Y h:i A')  }}</td>
                                    <td>{{ $fdr->plan->name }}</td>
                                    <td>{{ $fdr->fdr_id }}</td>
                                    <td>
                                        {{ $currencySymbol.$fdr->amount }}
                                    </td>
                                    <td>{{ $currencySymbol.$fdr->profit() }}</td>
                                    <td>
                                        @php
                                            $trx = \App\Models\FDRTransaction::where('fdr_id', $fdr->id)->where('paid_amount', null)->first();
                                        @endphp
                                        {{ $trx?->given_date?->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $fdr->totalInstallment() }}
                                    </td>
                                    <td>
                                        {{ $currencySymbol.$fdr->transactions->sum('paid_amount') }}
                                    </td>

                                    <td>
                                        @if($fdr->status->value == 'running')
                                            <div class="type site-badge primary">{{ ucfirst($fdr->status->value) }}</div>
                                        @elseif($fdr->status->value == 'closed')
                                            <div class="type site-badge danger">{{ ucfirst($fdr->status->value) }}</div>
                                        @elseif($fdr->status->value == 'mature')
                                            <div class="type site-badge success">{{ ucfirst($fdr->status->value) }}</div>
                                        @elseif($fdr->status->value == 'due')
                                            <div class="type site-badge pending">{{ ucfirst($fdr->status->value) }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found') }}!</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $fdres->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
