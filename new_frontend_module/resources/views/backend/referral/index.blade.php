@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Referral') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Referrals') }}</h2>
                            @can('referral-create')
                                <div class="d-flex">
                                    <a href="{{ route('admin.referral.settings') }}" class="title-btn mx-2"> <i data-lucide="settings"></i> {{ __('Referral Rules Settings') }}</a>
                                    <button class="title-btn new-referral" type="button"> <i data-lucide="plus-circle"></i> {{ __('Add New') }}</button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-4 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Deposit Bounty') }}</h3>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.referral.status') }}" method="post" id="deposit-status">
                                    @csrf
                                    <input type="hidden" name="type" value="deposit_level">
                                    <div class="switch-field m-0">
                                        <input
                                            type="radio"
                                            id="deposit-1"
                                            name="status"
                                            @checked(setting('deposit_level'))
                                        />
                                        <label for="deposit-1" class="deposit-status toggle-switch">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="deposit-0"
                                            name="status"
                                            @checked(!setting('deposit_level'))
                                        />
                                        <label for="deposit-0" class="deposit-status toggle-switch">{{ __('Deactive') }}</label>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="site-card-body">
                            <p class="paragraph">{{ __('You can') }}
                                <strong>{{ __('Add').','. __('Edit').' '. __('or').' '. __('Delete') }}</strong> {{ __('any of the') }}
                                <strong>{{ __('Level Referred User Deposit Bounty') }}</strong></p>

                            @foreach($deposits as $raw)
                                <div class="single-gateway">
                                    <div class="gateway-name">
                                        <div class="gateway-title">
                                            <h4>{{  __('Level '). $raw->the_order }}</h4>
                                        </div>
                                    </div>
                                    <div class="gateway-right">
                                        <div class="gateway-status">
                                            <div class="site-badge success">{{ $raw->bounty }}%</div>
                                        </div>
                                        <div class="gateway-edit">
                                            @can('referral-edit')
                                                <a href="" type="button" class="edit-referral"
                                                   data-id="{{$raw->id}}"
                                                   data-editfor="{{ 'Update ' . $raw->type . ' level '. $raw->the_order }}"
                                                   data-bounty="{{ $raw->bounty }}"
                                                ><i data-lucide="edit-3"></i></a>
                                            @endcan
                                            @can('referral-delete')
                                                <a href="" class="red-bg ms-2 delete-referral" type="button"
                                                   data-id="{{$raw->id}}"
                                                   data-type="{{$raw->type}}"
                                                   data-target="{{  $raw->type . ' level '. $raw->the_order }}"
                                                ><i data-lucide="trash-2"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('DPS Bounty') }}</h3>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.referral.status') }}" method="post" id="dps-status">
                                    @csrf
                                    <input type="hidden" name="type" value="dps_level">
                                    <div class="switch-field m-0">
                                        <input
                                            type="radio"
                                            id="dps-1"
                                            name="status"
                                            @checked(setting('dps_level'))
                                        />
                                        <label for="dps-1" class="dps-status toggle-switch">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="dps-0"
                                            name="status"
                                            @checked(!setting('dps_level'))
                                        />
                                        <label for="dps-0" class="dps-status toggle-switch">{{ __('Deactive') }}</label>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="site-card-body">
                            <p class="paragraph">{{ __('You can') }}
                                <strong>{{ __('Add').','. __('Edit').' '. __('or').' '. __('Delete') }}</strong> {{ __('any of the') }}
                                <strong>{{ __('Level Referred User DPS Bounty') }}</strong></p>

                            @foreach($dpses as $dps)
                                <div class="single-gateway">
                                    <div class="gateway-name">
                                        <div class="gateway-title">
                                            <h4>{{  __('Level '). $dps->the_order }}</h4>
                                        </div>
                                    </div>
                                    <div class="gateway-right">
                                        <div class="gateway-status">
                                            <div class="site-badge success">{{ $dps->bounty }}%</div>
                                        </div>
                                        <div class="gateway-edit">
                                            @can('referral-edit')
                                                <a href="" type="button" class="edit-referral"
                                                   data-id="{{$dps->id}}"
                                                   data-editfor="{{ 'Update ' . $dps->type . ' level '. $dps->the_order }}"
                                                   data-bounty="{{ $dps->bounty }}"
                                                ><i data-lucide="edit-3"></i></a>
                                            @endcan
                                            @can('referral-delete')
                                                <a href="" class="red-bg ms-2 delete-referral" type="button"
                                                   data-id="{{$dps->id}}"
                                                   data-type="{{$dps->type}}"
                                                   data-target="{{  $dps->type . ' level '. $dps->the_order }}"
                                                ><i data-lucide="trash-2"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('FDR Bounty') }}</h3>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.referral.status') }}" method="post" id="fdr-status">
                                    @csrf
                                    <input type="hidden" name="type" value="fdr_level">
                                    <div class="switch-field m-0">
                                        <input
                                            type="radio"
                                            id="fdr-1"
                                            name="status"
                                            @checked(setting('fdr_level'))
                                        />
                                        <label for="fdr-1" class="fdr-status toggle-switch">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="fdr-0"
                                            name="status"
                                            @checked(!setting('fdr_level'))
                                        />
                                        <label for="fdr-0" class="fdr-status toggle-switch">{{ __('Deactive') }}</label>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="site-card-body">
                            <p class="paragraph">{{ __('You can') }}
                                <strong>{{ __('Add').','. __('Edit').' '. __('or').' '. __('Delete') }}</strong> {{ __('any of the') }}
                                <strong>{{ __('Level Referred User FDR Bounty') }}</strong></p>

                            @foreach($fdrs as $fdr)
                                <div class="single-gateway">
                                    <div class="gateway-name">
                                        <div class="gateway-title">
                                            <h4>{{  __('Level '). $fdr->the_order }}</h4>
                                        </div>
                                    </div>
                                    <div class="gateway-right">
                                        <div class="gateway-status">
                                            <div class="site-badge success">{{ $fdr->bounty }}%</div>
                                        </div>
                                        <div class="gateway-edit">
                                            @can('referral-edit')
                                                <a href="" type="button" class="edit-referral"
                                                   data-id="{{$fdr->id}}"
                                                   data-editfor="{{ 'Update ' . $fdr->type . ' level '. $fdr->the_order }}"
                                                   data-bounty="{{ $fdr->bounty }}"
                                                ><i data-lucide="edit-3"></i></a>
                                            @endcan
                                            @can('referral-delete')
                                                <a href="" class="red-bg ms-2 delete-referral" type="button"
                                                   data-id="{{$fdr->id}}"
                                                   data-type="{{$fdr->type}}"
                                                   data-target="{{  $fdr->type . ' level '. $fdr->the_order }}"
                                                ><i data-lucide="trash-2"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Loan Bounty') }}</h3>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.referral.status') }}" method="post" id="loan-status">
                                    @csrf
                                    <input type="hidden" name="type" value="loan_level">
                                    <div class="switch-field m-0">
                                        <input
                                            type="radio"
                                            id="loan-1"
                                            name="status"
                                            @checked(setting('loan_level'))
                                        />
                                        <label for="loan-1" class="loan-status toggle-switch">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="loan-0"
                                            name="status"
                                            @checked(!setting('loan_level'))
                                        />
                                        <label for="loan-0" class="loan-status toggle-switch">{{ __('Deactive') }}</label>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="site-card-body">
                            <p class="paragraph">{{ __('You can') }}
                                <strong>{{ __('Add').','. __('Edit').' '. __('or').' '. __('Delete') }}</strong> {{ __('any of the') }}
                                <strong>{{ __('Level Referred User Loan Bounty') }}</strong></p>

                            @foreach($loans as $loan)
                                <div class="single-gateway">
                                    <div class="gateway-name">
                                        <div class="gateway-title">
                                            <h4>{{  __('Level '). $loan->the_order }}</h4>
                                        </div>
                                    </div>
                                    <div class="gateway-right">
                                        <div class="gateway-status">
                                            <div class="site-badge success">{{ $loan->bounty }}%</div>
                                        </div>
                                        <div class="gateway-edit">
                                            @can('referral-edit')
                                                <a href="" type="button" class="edit-referral"
                                                   data-id="{{$loan->id}}"
                                                   data-editfor="{{ 'Update ' . $loan->type . ' level '. $loan->the_order }}"
                                                   data-bounty="{{ $loan->bounty }}"
                                                ><i data-lucide="edit-3"></i></a>
                                            @endcan
                                            @can('referral-delete')
                                                <a href="" class="red-bg ms-2 delete-referral" type="button"
                                                   data-id="{{$loan->id}}"
                                                   data-type="{{$loan->type}}"
                                                   data-target="{{  $loan->type . ' level '. $loan->the_order }}"
                                                ><i data-lucide="trash-2"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Pay Bill Bounty') }}</h3>
                            <div class="col-sm-6">
                                <form action="{{ route('admin.referral.status') }}" method="post" id="bill-status">
                                    @csrf
                                    <input type="hidden" name="type" value="bill_level">
                                    <div class="switch-field m-0">
                                        <input
                                            type="radio"
                                            id="bill-1"
                                            name="status"
                                            @checked(setting('bill_level'))
                                        />
                                        <label for="bill-1" class="bill-status toggle-switch">{{ __('Active') }}</label>
                                        <input
                                            type="radio"
                                            id="bill-0"
                                            name="status"
                                            @checked(!setting('bill_level'))
                                        />
                                        <label for="bill-0" class="bill-status toggle-switch">{{ __('Deactive') }}</label>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="site-card-body">
                            <p class="paragraph">{{ __('You can') }}
                                <strong>{{ __('Add').','. __('Edit').' '. __('or').' '. __('Delete') }}</strong> {{ __('any of the') }}
                                <strong>{{ __('Level Referred User Pay Bill Bounty') }}</strong></p>

                            @foreach($bills as $bill)
                                <div class="single-gateway">
                                    <div class="gateway-name">
                                        <div class="gateway-title">
                                            <h4>{{  __('Level '). $bill->the_order }}</h4>
                                        </div>
                                    </div>
                                    <div class="gateway-right">
                                        <div class="gateway-status">
                                            <div class="site-badge success">{{ $bill->bounty }}%</div>
                                        </div>
                                        <div class="gateway-edit">
                                            @can('referral-edit')
                                                <a href="" type="button" class="edit-referral"
                                                   data-id="{{$bill->id}}"
                                                   data-editfor="{{ 'Update ' . $bill->type . ' level '. $bill->the_order }}"
                                                   data-bounty="{{ $bill->bounty }}"
                                                ><i data-lucide="edit-3"></i></a>
                                            @endcan
                                            @can('referral-delete')
                                                <a href="" class="red-bg ms-2 delete-referral" type="button"
                                                   data-id="{{$bill->id}}"
                                                   data-type="{{$bill->type}}"
                                                   data-target="{{  $bill->type . ' level '. $bill->the_order }}"
                                                ><i data-lucide="trash-2"></i></a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add New Level -->
        @can('referral-create')
            @include('backend.referral.include.__new_level_referral')
        @endcan
        <!-- Modal for Add New Level-->

        <!-- Modal for Edit Level -->
        @can('referral-edit')
            @include('backend.referral.include.__edit_level_referral')
        @endcan
        <!-- Modal for Edit Level-->

{{--        <!-- Modal for Delete Level -->--}}
        @can('referral-delete')
            @include('backend.referral.include.__delete_level_referral')
        @endcan
        <!-- Modal for Delete Level End-->

        @endsection
@section('script')
    <script>

        $('.new-referral').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var type = $(this).data('type');
            $('.referral-type').val(type);
            $('#addNewReferral').modal('show');

        })

        $('.edit-referral').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');
            var editFor = $(this).data('editfor');
            var bounty = $(this).data('bounty');

            var url = '{{ route("admin.referral.update",":id") }}';
            url = url.replace(':id', id);

            var form = document.getElementById("level-form");
            form.setAttribute("action", url);



            $('.referral-id').val(id);
            $('.edit-for').html(editFor);
            $('.bounty').val(bounty);

            $('#editReferral').modal('show');

        })
        $('.delete-referral').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');
            var target = $(this).data('target');
            var type = $(this).data('type');

            var url = '{{ route("admin.referral.delete",":id") }}';
            url = url.replace(':id', id);

            var form = document.getElementById("level-delete");
            form.setAttribute("action", url);

            $('.target').html(target);
            $('.level-type').val(type);
            $('#deleteReferral').modal('show');

        })



        $(".toggle-switch").click(function (message) {
            let className = $(this).attr('class');
            var idNames = className.split(' ')[0]; // Split the class names into an array
            $("#"+idNames).submit();
        });

    </script>
@endsection
