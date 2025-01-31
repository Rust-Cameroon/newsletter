@extends('backend.layouts.app')
@section('title')
    {{ __('Cron Job Logs') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title"> {{ __('Cron Job Logs') }}</h2>
                            <a href="{{ route('admin.cron.jobs.clear.logs',$id) }}" class="title-btn red-btn" type="button">
                                    <i data-lucide="trash-2"></i>
                                    {{ __('Clear Logs') }}
                            </a>
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
                                        <th scope="col">{{ __('Started At') }}</th>
                                        <th scope="col">{{ __('Ended At') }}</th>
                                        <th scope="col">{{ __('Duration') }}</th>
                                        <th scope="col">{{ __('Error') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>
                                                <strong>{{ $log->started_at->format('d M Y h:i A') }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $log->ended_at->format('d M Y h:i A') }}</strong>
                                            </td>
                                            <td>
                                                {{ $log->duration }} {{ __('Seconds') }}
                                            </td>
                                            <td>
                                                {{ $log->error }}
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="8" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
