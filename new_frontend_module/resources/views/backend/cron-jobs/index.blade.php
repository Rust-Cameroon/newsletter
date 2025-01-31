@extends('backend.layouts.app')
@section('title')
    {{ __('Cron Jobs') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Cron Jobs') }}</h2>
                            @can('cron-job-create')
                                <a href="" class="title-btn" type="button" data-bs-toggle="modal"
                                   data-bs-target="#addNewCron">
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
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Run Every') }}</th>
                                        <th scope="col">{{ __('Next Run At') }}</th>
                                        <th scope="col">{{ __('Last Run At') }}</th>
                                        <th scope="col">{{ __('Type') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($jobs as $job)
                                        <tr>

                                            <td>
                                                <strong>{{ $job->name }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $job->schedule }} {{ __('Seconds') }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $job->next_run_at->format('d M Y h:i A') }}</strong> <br>
                                                <span>({{ $job->next_run_at->diffForHumans() }})</span>
                                            </td>
                                            <td>
                                                <strong>{{ $job->last_run_at?->format('d M Y h:i A') ?? '--' }}</strong> <br>
                                                <span>({{ $job->last_run_at?->diffForHumans() }})</span>
                                            </td>
                                            <td>
                                                <strong>
                                                    @switch($job->type)
                                                        @case('system')
                                                            <div class="site-badge success">{{ __('System') }}</div>
                                                            @break
                                                        @case('custom')
                                                            <div class="site-badge pending">{{ __('Custom') }}</div>
                                                            @break
                                                    @endswitch
                                                </strong>
                                            </td>
                                            <td>
                                                <strong>
                                                    @switch($job->status)
                                                        @case('running')
                                                            <div class="site-badge success">{{ __('Running') }}</div>
                                                            @break
                                                        @case('paused')
                                                            <div class="site-badge pending">{{ __('Paused') }}</div>
                                                            @break
                                                    @endswitch
                                                </strong>
                                            </td>

                                            <td>
                                                @can('cron-job-logs')
                                                    <a href="{{ route('admin.cron.jobs.logs',encrypt($job->id)) }}" class="round-icon-btn grad-btn" data-bs-toggle="tooltip"
                                                    title="Logs" data-bs-original-title="Logs">
                                                        <i data-lucide="file-cog"></i>
                                                    </a>
                                                @endcan

                                                @can('cron-job-run')
                                                    <a href="{{ route('cron.job',['run_action' => $job->id]) }}" class="round-icon-btn blue-btn" data-bs-toggle="tooltip" title="Run Now" data-bs-original-title="Run Now">
                                                        <i data-lucide="refresh-ccw"></i>
                                                    </a>
                                                @endcan

                                                @can('cron-job-edit')
                                                    <button class="round-icon-btn primary-btn editBtn" data-bs-toggle="tooltip"
                                                    title="Edit" data-bs-original-title="Edit" type="button"
                                                            data-cron-job="{{ json_encode($job) }}">
                                                        <i data-lucide="edit-3"></i>
                                                    </button>
                                                @endcan

                                                @can('cron-job-delete')
                                                    @if($job->type == 'custom')
                                                    <button class="round-icon-btn red-btn delete-btn" data-bs-toggle="tooltip"
                                                    title="Delete" data-bs-original-title="Delete" data-id="{{ encrypt($job->id) }}" type="button">
                                                        <i data-lucide="trash"></i>
                                                    </button>
                                                    @endif
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
        @can('cron-job-create')
            @include('backend.cron-jobs.include.__add_new')
        @endcan
        <!-- Modal for Add New Earning-->

        <!-- Modal for Edit Earning -->
        @can('cron-job-edit')
            @include('backend.cron-jobs.include.__edit')
        @endcan
        <!-- Modal for Edit Earning-->

        <!-- Modal for Delete -->
        @can('cron-job-delete')
            @include('backend.cron-jobs.include.__delete')
        @endcan
        <!-- Modal for Delete Box End-->

    </div>
@endsection
@section('script')
    <script>
        "use strict";
        
        $('#portfolio_id').select2({
            dropdownParent : $('#addNewEarning'),
            minimumResultsForSearch: Infinity
        });

        $('.editBtn').on('click',function (e) {

            "use strict";

            e.preventDefault();
            var cron = $(this).data('cron-job');

            var url = '{{ route('admin.cron.jobs.update', ":id") }}';
            url = url.replace(':id', cron.id);

            $('#editCronForm').attr('action', url);
            $('#edit-name').val(cron.name);
            $('#edit-schedule').val(cron.schedule);
            $('#edit-next-run').val(moment(cron.next_run_at).format('YYYY-MM-DDThh:mm'));
            $('#edit-url').val(cron.url);
            $('#edit-status').val(cron.status);

            if(cron.type == 'system'){
                $('#url-area').hide();
            }else{
                $('#url-area').show();
            }

            $('#editCron').modal('show');
        });

        $('.delete-btn').on('click',function(){

            var url = '{{ route('admin.cron.jobs.delete', ":id") }}';
            url = url.replace(':id',$(this).attr('data-id'));

            $('#delete-form').attr('action',url);
            $('#deleteModal').modal('show');
        });
    </script>
@endsection
