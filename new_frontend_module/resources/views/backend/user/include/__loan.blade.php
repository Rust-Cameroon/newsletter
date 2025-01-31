@if(request('tab') == 'loan')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'loan'
    ])
    id="pills-loan"
    role="tabpanel"
    aria-labelledby="pills-loan-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Loan') }}</h4>
                </div>
                <div class="site-card-body table-responsive">
                    <div class="site-table">
                        <div class="table-filter">
                            <form action="" method="get">
                                <input type="hidden" name="tab" value="loan">
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
                                @include('backend.filter.th',['label' => 'Loan','field' => 'loan'])
                                @include('backend.filter.th',['label' => 'Loan ID','field' => 'loan_no'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'amount'])
                                <th>{{ __('Installment Amount') }}</th>
                                <th>{{ __('Next Payment') }}</th>
                                <th>{{ __('Installment') }}</th>
                                <th>{{ __('Paid') }}</th>
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($loans as $loan)
                                <tr>
                                    <td>{{ $loan->created_at->format('d M Y h:i A')  }}</td>
                                    <td>{{ $loan->plan->name }}</td>
                                    <td>{{ $loan->loan_no }}</td>
                                    <td>
                                        {{ $currencySymbol.$loan->amount }}
                                    </td>
                                    <td>{{ $currencySymbol.($loan->amount / 100 ) * $loan->plan->per_installment }}</td>
                                    <td>
                                        @if($loan->status == App\Enums\LoanStatus::Reviewing)
                                            -
                                        @else
                                            {{ nextInstallment($loan->id, \App\Models\LoanTransaction::class, 'loan_id') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $loan->plan->total_installment }}
                                    </td>
                                    <td>
                                        {{ $currencySymbol.$loan->transactions->sum('amount') }}
                                    </td>

                                    <td>
                                        @if($loan->status->value == 'running')
                                            <div class="type site-badge primary">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'rejected' || $loan->status->value == 'due')
                                            <div class="type site-badge danger">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'completed' )
                                            <div class="type site-badge success">{{ ucfirst($loan->status->value) }}</div>
                                        @elseif($loan->status->value == 'reviewing')
                                            <div class="type site-badge pending">{{ ucfirst($loan->status->value) }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found') }}!</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $loans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
