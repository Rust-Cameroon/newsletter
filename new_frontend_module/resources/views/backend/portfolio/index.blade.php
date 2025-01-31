@extends('backend.layouts.app')
@section('title')
    {{ __('Portfolios') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Portfolios') }}</h2>
                            @can('portfolio-create')
                                <a href="" class="title-btn" type="button" data-bs-toggle="modal"
                                   data-bs-target="#addNewPortfolio">
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
                                        <th scope="col">{{ __('Level') }}</th>
                                        <th scope="col">{{ __('Icon') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Minimum Transactions') }}</th>
                                        <th scope="col">{{ __('Bonus') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($portfolios as $portfolio)
                                        <tr>
                                            <td><strong>{{ $portfolio->level }}</strong></td>
                                            <td>
                                                <img class="avatar" src="{{ asset($portfolio->icon) }}" alt="">
                                            </td>
                                            <td>
                                                <strong>{{ $portfolio->portfolio_name }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $portfolio->minimum_transactions.' '.$currency }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $portfolio->bonus.' '.$currency }}</strong>
                                            </td>
                                            <td>{{ $portfolio->description }}</td>
                                            <td>
                                                @if($portfolio->status)
                                                    <div class="site-badge success">{{ __('Active') }}</div>
                                                @else
                                                    <div class="site-badge pending">{{ __('Disabled') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @can('portfolio-edit')
                                                    <button class="round-icon-btn primary-btn editPortfolio" type="button"
                                                            data-portfolio="{{ json_encode($portfolio) }}">
                                                        <i data-lucide="edit-3"></i>
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


        <!-- Modal for Add New Portfolio -->
        @can('portfolio-create')
            @include('backend.portfolio.include.__add_new')
        @endcan
        <!-- Modal for Add New Portfolio-->

        <!-- Modal for Edit Portfolio -->
        @can('portfolio-edit')
            @include('backend.portfolio.include.__edit')
        @endcan
        <!-- Modal for Edit Portfolio-->

    </div>
@endsection
@section('script')
    <script>
        $('.editPortfolio').on('click',function (e) {

            "use strict";

            e.preventDefault();
            var portfolio = $(this).data('portfolio');

            var url = '{{ route("admin.portfolio.update", ":id") }}';
            url = url.replace(':id', portfolio.id);

            $('#portfolioEditForm').attr('action', url)
            $('.level').val(portfolio.level);
            $('.portfolio-name').val(portfolio.portfolio_name);
            $('.minimum-transactions').val(portfolio.minimum_transactions);
            $('.bonus').val(portfolio.bonus);
            $('.description').val(portfolio.description);

            imagePreviewAdd(portfolio.icon);

            if (portfolio.status) {
                $('#disableStatus').attr('checked', false);
                $('#activeStatus').attr('checked', true);
            } else {
                $('#activeStatus').attr('checked', false);
                $('#disableStatus').attr('checked', true);
            }

            $('#editPortfolio').modal('show');
        });
    </script>
@endsection
