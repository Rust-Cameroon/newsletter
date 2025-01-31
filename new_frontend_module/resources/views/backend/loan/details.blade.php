@extends('backend.layouts.app')
@section('title')
    {{ __('Loan Details') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Loan Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title-small">{{ __('Plan Information') }}</h4>
                        </div>
                        <div class="site-card-body">
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Name') }}</div>
                                <div class="value">{{ $loan->plan->name }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Interval') }}</div>
                                <div class="value">{{ $loan->plan->installment_intervel }} Days</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Total Installment') }}</div>
                                <div class="value">{{ $loan->plan->total_installment }} Times</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Loan Amount') }}</div>
                                <div class="value">
                                    <div class="site-badge success">{{ $currencySymbol.$loan->amount }}</div>
                                </div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Per Installment') }}</div>
                                <div class="value">{{ $currencySymbol.(($loan->amount / 100 ) * $loan->plan->per_installment) }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Given Installment') }}</div>
                                <div class="value">{{ $loan->givenInstallemnt() ?? 0 }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Paid Amount') }}</div>
                                <div class="value">{{ $currencySymbol.$loan->transactions->sum('amount') ?? 0 }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Payable Amount') }}</div>
                                <div class="value">{{ $currencySymbol.$loan->totalPayableAmount() }}</div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Status') }}</div>
                                <div class="value">
                                    @include('backend.loan.include.__loan_status',['status' => $loan->status->value])
                                </div>
                            </div>
                            <div class="profile-text-data">
                                <div class="attribute">{{ __('Bank Profit') }}</div>
                                <div class="value">
                                    <div class="site-badge success">{{ $currencySymbol.$loan->totalPayableAmount()-$loan->amount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="site-card">
                        <div class="site-card-header">
                          <h4 class="title-small">{{ __('Loan Request Information') }}</h4>
                        </div>
                        <div class="site-card-body">
                            @foreach(json_decode($loan->submitted_data) as $key => $value)
                                <li class="profile-text-data">
                                    <div class="attribute"> {{ $key }}</div>
                                    <div class="value">
                                        @if($value != new stdClass())
                                        @if(file_exists(base_path('assets/'.$value)))
                                            {{-- <img src="{{ asset($value) }}" alt=""/> --}}
                                            <a href="{{ asset($value) }}" class="nav-link p-0" target="_blank">{{ __('Click here to view') }}</a>
                                        @else
                                            <strong>{{ $value }}</strong>
                                        @endif
                                    @endif
                                    </div>
                                </li>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($loan->status != App\Enums\LoanStatus::Reviewing && $loan->status != App\Enums\LoanStatus::Rejected && $loan->status != App\Enums\LoanStatus::Cancelled)
                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('SERIAL') }}</th>
                                    <th>{{ __('INSTALLMENT DATES') }}</th>
                                    <th>{{ __('GIVEN DATE') }}</th>
                                    <th>{{ __('DEFERMENT') }}</th>
                                    <th>{{ __('PAID AMOUNT') }}</th>
                                    <th>{{ __('CHARGE') }}</th>
                                    <th>{{ __('FINAL AMOUNT') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($loan->transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ safe($transaction->installment_date) }}</td>
                                    <td>{{ safe($transaction->given_date == null ? 'Yet To Pay' : $transaction->given_date) }}</td>
                                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->deferment) }}</td>
                                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->paid_amount) }}</td>
                                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->charge) }}</td>
                                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->final_amount) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif($loan->status == App\Enums\LoanStatus::Reviewing)
                    @can('loan-approval')
                        <form action="{{ route('admin.loan.approval.action',$loan->id) }}" method="post">
                            @csrf

                            <div class="action-btns">
                                <button type="submit" name="status" value="running" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Approve') }}
                                </button>
                                <button type="submit" name="status" value="rejected" class="site-btn-sm red-btn">
                                    <i data-lucide="x"></i>
                                    {{ __('Reject') }}
                                </button>
                            </div>

                        </form>
                    @endcan
                @endif
            </div>
        </div>


    </div>
@endsection
