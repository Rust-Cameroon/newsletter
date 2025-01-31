@extends('backend.layouts.app')
@section('title')
{{ __($statusForFrontend.' Fund Transfer') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="title-content">
                        <h2 class="title">{{ __($statusForFrontend.' Fund Transfer') }}</h2>
                        @if ($statusForFrontend == 'Wire')
                            <a href="{{ route('admin.wire.transfer') }}" class="title-btn"><i data-lucide="cog"></i>{{ __('Wire Transfer Settings')
                                }}</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-md-12">
                <div class="site-card">
                    <div class="site-card-body table-responsive">
                        <div class="site-table table-responsive">
                            @php
                                $status = $statusForFrontend == 'Pending' || $statusForFrontend == 'Rejected' ? false : true;
                                $type = $statusForFrontend == 'Allied' || $statusForFrontend == 'Other Bank' || $statusForFrontend == 'Wire' ? false : true;
                            @endphp
                            @include('backend.fund-transfer.include.__filter',['status' => $status, 'type' => $type ])
                            <table class="table">
                                <thead>
                                    <tr>
                                        @include('backend.filter.th',['label' => 'Date','field' => 'created_at'])
                                        @include('backend.filter.th',['label' => 'Transaction ID','field' => 'tnx'])
                                        @include('backend.filter.th',['label' => 'Sender','field' => 'sender'])
                                        <th>{{ __('Receiver') }}</th>
                                        @include('backend.filter.th',['label' => 'Amount','field' => 'final_amount'])
                                        @include('backend.filter.th',['label' => 'Transfer Type','field' => 'type'])
                                        @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lists as $list)
                                    <tr>
                                        <td>
                                            {{ $list->created_at }}
                                        </td>
                                        <td>
                                            {{ safe($list->tnx) }}
                                        </td>
                                        <td>
                                            @include('backend.transaction.include.__user',
                                            [
                                                'id' => $list->user_id,
                                                'name' => $list->user->username
                                            ])
                                        </td>
                                        <td>
                                            @php
                                            $fieldData = json_decode($list->manual_field_data, true)
                                            @endphp

                                            @if($list->transfer_type->value != 'wire_transfer')
                                                {{ $list->beneficiary->account_name ?? data_get($fieldData,'account_name','-') }}
                                            @else
                                                {{ data_get($fieldData, 'name_of_account') }}
                                            @endif
                                        </td>
                                        <td>
                                            @include('backend.transaction.include.__txn_amount', ['txnType' =>
                                            $list->type,
                                            'amount' => $list->final_amount, 'currency' => $list->pay_currency])
                                        </td>
                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $list->transfer_type->value)) }}
                                        </td>
                                        <td>
                                            @include('backend.transaction.include.__txn_status', ['txnStatus' =>
                                            $list->status->value])
                                        </td>
                                        <td>
                                            @include('backend.fund-transfer.include.__action', ['id' => $list->id])
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $lists->links('backend.include.__pagination') }}
                        </div>

                        <div class="modal fade" id="details-modal" tabindex="-1" aria-labelledby="editPendingDepositModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content site-table-modal">
                                    <div class="modal-body popup-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        </button>
                                        <div class="popup-body-text" id="modal-data">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>

    let loader = '<div class="text-center"><img src="{{ asset('front/images/loader.gif') }}" width="100"><h5>{{ __('Please wait') }}...</h5></div>';

    $('body').on('click', '#action', function (e) {
        e.preventDefault();

        $('#modal-data').empty();
        $('#modal-data').html(loader);

        var id = $(this).data('id');
        var url = '{{ route("admin.fund.transfer.details",":id") }}';
        url = url.replace(':id', id);

        $.get(url, function (data) {
            $('#modal-data').html(data);
        });

        $('#details-modal').modal('toggle');
    });
</script>
@endsection
