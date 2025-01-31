@extends('backend.layouts.app')
@section('title')
    {{ __('All Subscribers') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('All Subscribers') }}</h2>
                            @can('subscriber-mail-send')
                                <a href="{{ route('admin.mail.send.subscriber') }}" class="title-btn"><i
                                        data-lucide="mail"></i>{{ __('Email To All') }}</a>
                            @endcan
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
                            @include('backend.subscriber.include.__filter', ['status' => false])
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('Subscription Date') }}</th>
                                    <th>{{ __('Email') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($subscribes as $subscribe)
                                    <tr>
                                        <td>
                                            {{ safe($subscribe->created_at) }}
                                        </td>
                                        <td>
                                            {{ safe($subscribe->email) }}
                                        </td>
                                    </tr>
                                @empty
                                <td colspan="2" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                                </tbody>
                            </table>

                            {{ $subscribes->links('backend.include.__pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

