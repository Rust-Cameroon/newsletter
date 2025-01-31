@extends('backend.layouts.app')
@section('title')
    {{ __('Reward Point Redeem') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Reward Point Redeem') }}</h2>
                            @can('reward-redeem-create')
                                <a href="" class="title-btn" type="button" data-bs-toggle="modal"
                                   data-bs-target="#addNewRedeem">
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
                                        <th scope="col">{{ __('Per Point') }}</th>
                                        <th scope="col">{{ __('Redeem Amount') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($redeems as $redeem)
                                        <tr>

                                            <td>
                                                <strong>{{ $redeem->portfolio->portfolio_name }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $redeem->point }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $currencySymbol.$redeem->amount }}</strong>
                                            </td>
                                            <td>
                                                @can('reward-redeem-edit')
                                                    <button class="round-icon-btn primary-btn editBtn" type="button"
                                                            data-redeem="{{ json_encode($redeem) }}">
                                                        <i data-lucide="edit-3"></i>
                                                    </button>
                                                @endcan

                                                @can('reward-redeem-delete')
                                                    <button class="round-icon-btn red-btn delete-btn" data-id="{{ $redeem->id }}" type="button">
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


        <!-- Modal for Add New redeem -->
        @can('reward-redeem-create')
            @include('backend.reward-point.redeem.include.__add_new')
        @endcan
        <!-- Modal for Add New redeem-->

        <!-- Modal for Edit redeem -->
        @can('reward-redeem-edit')
            @include('backend.reward-point.redeem.include.__edit')
        @endcan
        <!-- Modal for Edit redeem-->

        <!-- Modal for Delete -->
        @can('reward-redeem-delete')
            @include('backend.reward-point.redeem.include.__delete')
        @endcan
        <!-- Modal for Delete Box End-->

    </div>
@endsection
@section('script')
    <script>

        $('#portfolio_id').select2({
            dropdownParent : $('#addNewRedeem'),
            minimumResultsForSearch: Infinity
        });

        $('.editBtn').on('click',function (e) {

            "use strict";

            e.preventDefault();
            var redeem = $(this).data('redeem');

            var url = '{{ route("admin.reward.point.redeem.update", ":id") }}';
            url = url.replace(':id', redeem.id);

            $('#redeemEditForm').attr('action', url);
            $('#edit_portfolio_id').val(redeem.portfolio_id);
            $('.amount').val(redeem.amount);
            $('.point').val(redeem.point);

            $('#edit_portfolio_id').select2({
                dropdownParent : $('#editRedeem'),
                minimumResultsForSearch: Infinity
            });

            $('#editRedeem').modal('show');
        });

        $('.delete-btn').on('click',function(){

            var url = '{{ route("admin.reward.point.redeem.destroy", ":id") }}';
            url = url.replace(':id',$(this).attr('data-id'));

            $('#delete-form').attr('action',url);
            $('#deleteModal').modal('show');
        });
    </script>
@endsection
