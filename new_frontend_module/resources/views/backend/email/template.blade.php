@extends('backend.layouts.app')
@section('title')
    {{ __('Email Template') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Email Template') }}</h2>
                            <a href="{{ route('admin.settings.mail') }}" class="title-btn"><i
                                    data-lucide="mail"></i>{{ __('Email Config') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card-body table-responsive">
                        <div class="site-table table-responsive">
                            @include('backend.email.include.__filter', ['status' => true])
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('Email For') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($emails as $email)
                                    <tr>
                                        <td>
                                            @include('backend.email.include.__name', ['name' => $email->name, 'for' => $email->for])
                                        </td>
                                        <td>
                                            @include('backend.email.include.__status', ['status' => $email->status])
                                        </td>
                                        <td>
                                            @include('backend.email.include.__action', ['id' => $email->id])
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="3" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                                </tbody>
                            </table>

                            {{ $emails->links('backend.include.__pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

