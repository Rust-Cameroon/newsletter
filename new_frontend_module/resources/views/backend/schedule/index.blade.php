@extends('backend.layouts.app')
@section('title')
    {{ __('Schedule') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('All Schedules') }}</h2>
                            <a
                                href=""
                                class="title-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#addNewSchedule"
                            ><i data-lucide="plus-circle"></i>{{ __('Add New') }}</a>
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
                                        <th scope="col">{{ __('#') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Time') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td>{{$schedule->name}}</td>
                                            <td>
                                                <strong>{{$schedule->time}} @php echo $schedule->time > 1 ? 'Hours' : 'Hour' @endphp</strong>
                                            </td>
                                            <td>
                                                <button
                                                    class="round-icon-btn primary-btn"
                                                    type="button"
                                                    id="edit"
                                                    data-id="{{$schedule->id}}"
                                                >
                                                    <i data-lucide="edit-3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="4" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Add New Schedule -->
        @include('backend.schedule.modal.__new_schedule')
        <!-- Modal for Add New Schedule-->

        <!-- Modal for Edit Schedule -->
        @include('backend.schedule.modal.__edit_schedule')
        <!-- Modal for Edit Schedule-->

    </div>
@endsection

@section('script')
    <script>

        $('body').on('click', '#edit', function (event) {
            "use strict";
            event.preventDefault();
            $('#editModal').modal('show');
            var id = $(this).data('id');
            $.get('schedule/' + id + '/edit', function (data) {

                var url = '{{ route("admin.schedule.update", ":id") }}';
                url = url.replace(':id', id);
                $('#editForm').attr('action', url)

                $('#name').val(data.name);
                $('#time').val(data.time);
                if (data.time <= 1) {
                    $('#time-level').html('Hour');
                } else {
                    $('#time-level').html('Hours');
                }
            })
        });

    </script>
@endsection
