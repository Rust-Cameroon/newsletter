@extends('backend.layouts.app')
@section('title')
    {{ __('Footer Contents') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Footer Contents') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-tab-bars">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                @foreach($languages as $language)
                    <li class="nav-item" role="presentation">
                        <a
                            href=""
                            class="nav-link  {{ $loop->index == 0 ?'active' : '' }}"
                            id="pills-informations-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#{{$language->locale}}"
                            type="button"
                            role="tab"
                            aria-controls="pills-informations"
                            aria-selected="true"
                        ><i data-lucide="languages"></i>{{$language->name}}</a
                        >
                    </li>
                @endforeach


            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">

            @foreach($groupData as $key => $value)

                @php
                    $data = new Illuminate\Support\Fluent($value);
                @endphp

                <div
                    class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}"
                    id="{{$key}}"
                    role="tabpanel"
                    aria-labelledby="pills-informations-tab"
                >

                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Image and Widget Contents') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section_code" value="footer">
                                <input type="hidden" name="section_locale" value="{{$key}}">

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Description') }}<i data-lucide="info"
                                                                                                       data-bs-toggle="tooltip"
                                                                                                       title=""
                                                                                                       data-bs-original-title="Change the Left Widget Description"></i></label>
                                    <div class="col-sm-9">
                                        <textarea name="widget_left_description" class="form-textarea"
                                                  placeholder="Description">{{ $data->widget_left_description }}</textarea>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget Middle 1 Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Middle 1 Widget Title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="widget_title_1" class="box-input"
                                               value="{{ $data->widget_title_1 }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget Middle 2 Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Middle 2 Widget Title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="widget_title_2" class="box-input"
                                               value="{{ $data->widget_title_2 }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget Right Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Right Widget Title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="widget_title_3" class="box-input"
                                               value="{{ $data->widget_title_3 }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Email Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Contact Email Title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="contact_email_title" class="box-input"
                                               value="{{ $data->contact_email_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Email Address') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Contact Email Address"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="contact_email_address" class="box-input"
                                               value="{{ $data->contact_email_address }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Telegram Title') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Contact Phone Title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="contact_telegram_title" class="box-input"
                                               value="{{ $data->contact_telegram_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Telegram Link') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Contact Telegram Link"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="contact_telegram_link" class="box-input"
                                               value="{{ $data->contact_telegram_link }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Copyright Text') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change the Copyright Text"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="copyright_text" class="box-input"
                                               value="{{ $data->copyright_text }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="offset-sm-3 col-sm-9">
                                        <div class="paragraph"><i data-lucide="alert-triangle"></i>{{ __('All the') }}
                                            <strong>{{ __('Footer Menus') }}</strong> {{ __('will come from') }} <a
                                                href="{{ route('admin.navigation.footer') }}"
                                                class="link">{{ __('Menu Management') }}</a></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            @endforeach
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Social Icons') }}</h3>
                    <div class="card-header-links">
                        <a href="" class="card-header-link" type="button" data-bs-toggle="modal"
                            data-bs-target="#addNew">{{ __('Add New') }}</a>
                    </div>
                </div>


                <form action="{{ route('admin.social.position.update') }}" method="post">
                    @csrf
                    <div class="site-card-body">
                        <p class="paragraph"><i data-lucide="alert-triangle"></i>{{ __('All the') }}
                            <strong>{{ __('Social Icons are Draggable.') }}</strong> {{ __('Once you drag then click') }}
                            <strong>{{ __('Save Changes') }}</strong></p>
                        <div class="site-table table-responsive mb-0">
                            <table class="table mb-0" id="sortable">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Icon Name') }}</th>
                                    <th scope="col">{{ __('Class Name') }}</th>
                                    <th scope="col">{{ __('URL') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($socials as $social)
                                    <tr>
                                        <input type="hidden" name="{{ $loop->index }}"
                                                value="{{ $social->id }}">
                                        <td>
                                            <strong>{{ $social->icon_name }}</strong>
                                        </td>
                                        <td>{{ $social->class_name }}</td>
                                        <td><strong>{{ $social->class_name }}</strong></td>
                                        <td>
                                            <button class="round-icon-btn primary-btn editContent" type="button"
                                                    data-content="{{ $social }}">
                                                <i data-lucide="edit-3"></i>
                                            </button>
                                            <button class="round-icon-btn red-btn deleteContent" type="button"
                                                    data-id="{{ $social->id }}">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="site-card-footer">
                        <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal for Add New  -->
    @include('backend.page.section.include.__add_new_social')
    <!-- Modal for Add New How It Works End -->

    <!-- Modal for Edit -->
    @include('backend.page.section.include.__edit_social')
    <!-- Modal for Edit  End-->

    <!-- Modal for Delete  -->
    @include('backend.page.section.include.__delete_social')
    <!-- Modal for Delete  End-->

@endsection
@section('script')
    <script>
        $(function () {
            'use strict';
            $("#sortable tbody").sortable({
                cursor: "move",
                placeholder: "sortable-placeholder",
                helper: function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function (index) {
                        // Set helper cell sizes to match the original sizes
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                }
            }).disableSelection();
        });
        $('.editContent').on('click',function (e) {
            "use strict";
            e.preventDefault();
            var content = $(this).data('content');


            imagePreviewAdd(content.icon);
            $('#updatedId').val(content.id);
            $('.icon_name').val(content.icon_name);
            $('.class_name').val(content.class_name);
            $('.url').val(content.url);
            $('#editContent').modal('show');
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
