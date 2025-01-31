@extends('backend.layouts.app')
@section('title')
    {{ __($statusForFrontend.' Loan') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __($statusForFrontend.' Loan') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-table table-responsive">
                        @include('backend.loan.include.__filter', ['status' => false, 'type' => false ])
                        <table class="table">
                            <thead>
                            <tr>
                                @include('backend.filter.th',['label' => 'Plan','field' => 'plan'])
                                @include('backend.filter.th',['label' => 'User','field' => 'user'])
                                @include('backend.filter.th',['label' => 'Loan ID','field' => 'loan_no'])
                                @include('backend.filter.th',['label' => 'Amount','field' => 'amount'])
                                <th>{{ __('Installment Amount') }}</th>
                                <th>{{ __('Next Installment') }}</th>
                                @include('backend.filter.th',['label' => 'Requested At','field' => 'created_at'])
                                @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($loan as $item)
                                <tr>
                                    <td>
                                        {{ $item->plan->name }}
                                    </td>
                                    <td>
                                        @include('backend.loan.include.__user', ['id' => $item->user_id, 'name' => $item->user->username])
                                    </td>
                                    <td>{{ safe($item->loan_no) }}</td>
                                    <td>
                                        {{ $currencySymbol.safe($item->amount)  }}
                                    </td>
                                    <td>
                                        {{ $currencySymbol }}{{ safe(($item->amount / 100 ) * $item->plan->per_installment) }}
                                    </td>
                                    <td>
                                        @if($item->status == App\Enums\LoanStatus::Reviewing)
                                            -
                                        @else
                                            {{ nextInstallment($item->id, \App\Models\LoanTransaction::class, 'loan_id') }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ safe($item->created_at->format('d M Y h:i A')) }}
                                    </td>
                                    <td>
                                        @include('backend.loan.include.__loan_status', ['status' => $item->status->value])
                                    </td>
                                    <td>
                                        @include('backend.loan.include.__action', ['id' => $item->id , 'status' => $item->status])
                                    </td>
                                </tr>
                            @empty
                            <td colspan="9" class="text-center">{{ __('No Data Found!') }}</td>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $loan->links('backend.include.__pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

