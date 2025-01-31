@extends('backend.layouts.app')
@section('title')
    {{ __('Reward Point Earnings') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Reward Point Earnings') }}</h2>
                            @can('reward-earning-create')
                                <a href="" class="title-btn" type="button" data-bs-toggle="modal"
                                   data-bs-target="#addNewEarning">
                                    <i data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('Portfolio') }}</th>
                                        <th scope="col">{{ __('Amount Of Transactions') }}</th>
                                        <th scope="col">{{ __('Reward Point') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($earnings as $earning)
                                        <tr>

                                            <td>
                                                <strong>{{ $earning->portfolio->portfolio_name }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $currencySymbol.$earning->amount_of_transactions }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $earning->point }}</strong>
                                            </td>
                                            <td>
                                                @can('reward-earning-edit')
                                                    <button class="round-icon-btn primary-btn editBtn" type="button"
                                                            data-earning="{{ json_encode($earning) }}">
                                                        <i data-lucide="edit-3"></i>
                                                    </button>
                                                @endcan

                                                @can('reward-earning-delete')
                                                    <button class="round-icon-btn red-btn delete-btn" data-id="{{ $earning->id }}" type="button">
                                                        <i data-lucide="trash"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="8" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal for Add New Earning -->
        @can('reward-earning-create')
            @include('backend.reward-point.earning.include.__add_new')
        @endcan
        <!-- Modal for Add New Earning-->

        <!-- Modal for Edit Earning -->
        @can('reward-earning-edit')
            @include('backend.reward-point.earning.include.__edit')
        @endcan
        <!-- Modal for Edit Earning-->

        <!-- Modal for Delete -->
        @can('reward-earning-delete')
            @include('backend.reward-point.earning.include.__delete')
        @endcan
        <!-- Modal for Delete Box End-->

    </div>
@endsection
@section('script')
    <script>

        $('#portfolio_id').select2({
            dropdownParent : $('#addNewEarning'),
            minimumResultsForSearch: Infinity
        });

        $('.editBtn').on('click',function (e) {

            "use strict";

            e.preventDefault();
            var earning = $(this).data('earning');

            var url = '{{ route("admin.reward.point.earnings.update", ":id") }}';
            url = url.replace(':id', earning.id);

            $('#earningEditForm').attr('action', url);
            $('#edit_portfolio_id').val(earning.portfolio_id);
            $('.amount-of-transactions').val(earning.amount_of_transactions);
            $('.point').val(earning.point);

            $('#edit_portfolio_id').select2({
                dropdownParent : $('#editEarning'),
                minimumResultsForSearch: Infinity
            });

            $('#editEarning').modal('show');
        });

        $('.delete-btn').on('click',function(){

            var url = '{{ route("admin.reward.point.earnings.destroy", ":id") }}';
            url = url.replace(':id',$(this).attr('data-id'));

            $('#delete-form').attr('action',url);
            $('#deleteModal').modal('show');
        });
    </script>
@endsection
