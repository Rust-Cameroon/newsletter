@extends('frontend::layouts.user')
@section('title')
    {{ __('Beneficiary List') }}
@endsection
@section('content')
    <div class="row">
        @include('frontend::fund_transfer.include.__header')
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="title-small">{{ __('Beneficiary List') }}</div>
                    <div class="card-header-links">
                        <a href="" class="card-header-link" data-bs-toggle="modal" data-bs-target="#addBox"><i
                                data-lucide="plus-circle"></i>{{ __('Add Beneficiary') }}</a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('Bank Name') }}</div>
                                <div class="site-table-col">{{ __('Account Number') }}</div>
                                <div class="site-table-col">{{ __('Name on Account') }}</div>
                                <div class="site-table-col">{{ __('Branch Name') }}</div>
                                <div class="site-table-col">{{ __('Nick name') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @forelse($beneficiary as $item)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div
                                            class="trx fw-bold">{{ $item->bank_id == null ? 'Own Bank' : $item->bank->name }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $item->account_number }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $item->account_name }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $item->branch_name ?? '-' }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">{{ $item->nick_name }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="action">
                                            <a href="" class="icon-btn me-2 sendMoneyBtn" data-id="{{ $item->id }}"
                                                data-charge-type="{{ $item->bank_id !== null ? $item->bank->charge_type : 'percentage' }}"
                                          data-charge="{{ $item->bank_id !== null ? $item->bank->charge : 0 }}" data-bs-toggle="modal"
                                               data-bs-target="#sendBox"><i data-lucide="send"></i>{{ __('Send Money') }}</a>
                                            <span data-bs-toggle="modal" data-bs-target="#detailsBox">
                                      <button
                                          class="circle-btn grad-btn viewBtn"
                                          data-id="{{ $item->id }}"
                                          data-name="{{ $item->bank_id == null ? 'Own Bank' : $item->bank->name }}"
                                          data-number="{{ $item->account_number }}"

                                          data-account="{{ $item->account_name }}"
                                          data-branch="{{ $item->branch_name }}"
                                          data-nickname="{{ $item->nick_name }}"
                                          data-bs-custom-class="custom-tooltip"
                                          data-bs-toggle="tooltip"
                                          data-bs-placement="top"
                                          data-bs-title="View Details">
                                        <i data-lucide="eye"></i>
                                      </button>
                                </span>
                                <span type="button" data-bs-toggle="modal" data-bs-target="#editBox">
                                  <button
                                      class="circle-btn blue-btn editBtn"
                                      data-id="{{ $item->id }}"
                                      data-bank-id="{{ $item->bank_id ?? 'null' }}"
                                      data-name="{{ $item->bank_id }}"
                                      data-number="{{ $item->account_number }}"
                                      data-account="{{ $item->account_name }}"
                                      data-branch="{{ $item->branch_name }}"
                                      data-nickname="{{ $item->nick_name }}"
                                      data-bs-custom-class="custom-tooltip"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="top"
                                      data-bs-title="Edit">
                                    <i data-lucide="edit-3"></i>
                                  </button>
                                </span>
                                            <span type="button" data-bs-toggle="modal" data-bs-target="#deleteBox">
                                  <button class="circle-btn red-btn dltBtn" data-id="{{ $item->id }}" data-bs-custom-class="custom-tooltip"
                                          data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                    <i data-lucide="trash-2"></i>
                                  </button>
                                </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <div class="text-center">{{ __('No Data Found!') }}</div>
                            @endforelse
                        </div>
                        <!-- <div class="no-data-found">No Data Found</div> -->
                    </div>
                    <!-- Modal for Delete Box -->
                    @include('frontend::fund_transfer.include.__delete_beneficiary')
                    <!-- Modal for Delete Box End-->

                    <!-- Modal for Edit beneficiary-->
                    @include('frontend::fund_transfer.include.__edit_beneficiary')
                    <!-- Modal for Edit beneficiary end-->

                    <!-- Modal for Send Money beneficiary-->
                    @include('frontend::fund_transfer.include.__send_money')
                    <!-- Modal for Send Money beneficiary end-->

                    <!-- Modal for Details beneficiary-->
                    @include('frontend::fund_transfer.include.__details_beneficiary')
                    <!-- Modal for Detials beneficiary end-->

                    <!-- Modal for Add beneficiary-->
                    @include('frontend::fund_transfer.include.__add_beneficiary')
                    <!-- Modal for Add beneficiary end-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            "use strict"
            var currency = @json($currency);

            var charge_type,charge;

            // nice select
            $('.add-beneficiary').niceSelect();
            $('.edit-beneficiary').niceSelect();

            // own bank select event
            $(document).on('change','.bank_name', function (e) {
                if ($(this).val() == null) {
                    $('#branch_name_sec').hide();
                } else {
                    $('#branch_name_sec').show();
                }
            })

            // View Details
            $(document).on('click','.viewBtn',function(){
                let name = $(this).data('name');
                let number = $(this).data('number');
                let account = $(this).data('account');
                let branch = $(this).data('branch');
                let nickname = $(this).data('nickname');
                let id = $(this).data('id');

                $("#bank_name").html(name);
                $("#account_number").html(number);
                $("#account_name").html(account);
                $("#branch_name").html(branch);
                $("#nick_name").html(nickname);

                $.ajax({
                    type: 'GET',
                    url: '/user/fund-transfer/beneficiary/show/' + id,
                    success: function (data) {
                        $("#beneficiary_id").val(id);
                        $("#bank_id").val(data.bank_id);
                        $('.min-max').text('Minimum ' + data.bank.minimum_transfer + ' ' + currency + ' and ' + 'Maximum ' + data.bank.maximum_transfer + ' ' + currency)
                        $('.daily_limit').text('Max ' + data.bank.daily_limit_maximum_amount + ' ' + currency)
                        $('.monthly_limit').text('Max ' + data.bank.monthly_limit_maximum_amount + ' ' + currency)
                        $('.charge').text('Charge ' + data.bank.charge + ' ' + (data.bank.charge_type === 'percentage' ? ' % ' : currency))
                    },
                    error: function (error) {
                        console.error('Error fetching beneficiaries:', error);
                    }
                });
            });

            // Delete Btn Click
            $(document).on('click','.dltBtn',function(){
                let dataId = $(this).data('id');
                $("#dltId").val(dataId);
            });

            //edit Btn
            $(document).on('click','.editBtn',function(){
                let name = $(this).data('name');
                let number = $(this).data('number');
                let account = $(this).data('account');
                let branch = $(this).data('branch');
                let nickname = $(this).data('nickname');
                let id = $(this).data('id');
                let bank_id = $(this).data('bank-id');

                $("#edit_id").val(id);
                $("#edit_bank_name").val(bank_id ?? 'null').niceSelect('update');;
                $("#edit_account_number").val(number);
                $("#edit_account_name").val(account);
                $("#edit_branch_name").val(branch);
                $("#edit_nick_name").val(nickname);
            });


            $(document).on('click','.sendMoneyBtn',function(){
                charge_type = $(this).data('charge-type');
                charge = $(this).data('charge');
                let id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: '/user/fund-transfer/beneficiary/show/' + id,
                    success: function (data) {
                        $("#beneficiary_id").val(id);
                        $("#bank_id").val(data.bank_id);
                        $('.min-max').text('Minimum ' + data.bank.minimum_transfer + ' ' + currency + ' and ' + 'Maximum ' + data.bank.maximum_transfer + ' ' + currency)
                    },
                    error: function (error) {
                        console.error('Error fetching beneficiaries:', error);
                    }
                });
            });

            $('#send-money-amount').on('keyup', function (e) {
                var amount = $(this).val();

                $('.transfer_amount').text((Number(amount) + ' ' + currency))
                $('.currency').text(currency)
                var total_charge = charge_type === 'percentage' ? amount*charge/100 : charge
                $('.transfer_charge').text(total_charge + ' ' + currency)
                var total = (Number(amount) + Number(charge));
                $('.total_transfer').text(total + ' ' + currency)
            });
        })

    </script>
@endsection
