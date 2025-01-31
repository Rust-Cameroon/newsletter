@extends('backend.layouts.app')
@section('title')
    {{ __('Work Step Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Work Step Section') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Visibility') }}</h3>
            </div>
            <div class="site-card-body">
                <form action="{{ route('admin.page.section.section.update') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="section_code" value="workstepsection">
                    <input type="hidden" name="section_locale" value="en">
                    <div class="site-input-groups row">
                        <label for="" class="col-sm-3 col-label pt-0">{{ __('Section Visibility') }}<i
                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                data-bs-original-title="Manage Section Visibility"></i></label>
                        <div class="col-sm-3">
                            <div class="site-input-groups">
                                <div class="switch-field">
                                    <input type="radio" id="active" name="status" @if($status) checked
                                           @endif value="1"/>
                                    <label for="active">{{ __('Show') }}</label>
                                    <input type="radio" id="deactivate" name="status" @if(!$status) checked
                                           @endif value="0"/>
                                    <label for="deactivate">{{ __('Hide') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-sm-3 col-sm-9">
                            <button type="submit" class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Contents') }}</h3>
                <div class="card-header-links">
                    <a href="" class="card-header-link" type="button" data-bs-toggle="modal"
                        data-bs-target="#addNew">{{ __('Add New') }}</a>
                </div>
            </div>
            <div class="site-card-body">
                <div class="site-table table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('Icon') }}</th>
                            <th scope="col">{{ __('Title') }}</th>
                            <th scope="col">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($landingContent as $content)
                            <tr>
                                <td>
                                    <img class="avatar avatar-round" src="{{ asset($content->icon) }}" alt="" height="40" width="40">
                                </td>
                                <td>
                                    {{ $content->title }}
                                </td>
                                <td>
                                    <button class="round-icon-btn primary-btn editContent" type="button"
                                            data-id="{{ $content->id }}">
                                        <i data-lucide="edit-3"></i>
                                    </button>
                                    <button class="round-icon-btn red-btn deleteContent" type="button"
                                            data-id="{{ $content->id }}">
                                        <i data-lucide="trash-2"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add New  -->
    @include('backend.page.section.include.__add_new_work_step')
    <!-- Modal for Add New End -->

    <!-- Modal for Edit -->
    @include('backend.page.section.include.__edit_work_step')
    <!-- Modal for Edit  End-->

    <!-- Modal for Delete  -->
    @include('backend.page.section.include.__delete_work_step')
    <!-- Modal for Delete  End-->
@endsection
@section('script')
    <script>
        $('.editContent').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');

            var url = '{{ route("admin.page.content-edit", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Handle the response HTML
                    $('#target-element').html(response.html);
                    $('#editContent').modal('show');
                },
                error: function(xhr) {
                    // Handle any errors that occurred during the request
                    console.log(xhr.responseText);
                }
            });
        });

        $('.deleteContent').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteId').val(id);
            $('#deleteContent').modal('show');
        });
    </script>
@endsection
