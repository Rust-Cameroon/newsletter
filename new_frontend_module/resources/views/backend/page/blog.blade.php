@extends('backend.layouts.app')
@section('title')
    {{ __('Blog') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Blog Page') }}</h2>
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

                <div class="tab-pane fade {{ $loop->index == 0 ?'show active' : '' }}" id="{{$key}}" role="tabpanel" aria-labelledby="pills-informations-tab">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Contents') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="page_code" value="blog">
                                <input type="hidden" name="page_locale" value="{{$key}}">
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Page Title') }}<i data-lucide="info"
                                                                                                      data-bs-toggle="tooltip"
                                                                                                      title=""
                                                                                                      data-bs-original-title="Page Title will show on Breadcrumb"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" value="{{ $data->title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for=""
                                           class="col-sm-3 col-label">{{ __('Blog Details Page Sidebar') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sidebar_widget_title" class="box-input"
                                               value="{{ $data->sidebar_widget_title }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="" class="col-sm-3 col-label"></label>
                                    <div class="col-sm-9">
                                        <hr>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Keywords') }}<i data-lucide="info"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title=""
                                                                                                        data-bs-original-title="Page Seo Keywords"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="meta_keywords" class="box-input"
                                               value="{{ $data->meta_keywords }}">
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Seo Description') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Page Seo Description"></i></label>
                                    <div class="col-sm-9">
                                        <textarea name="meta_description" cols="30" rows="5" class="form-textarea">{{ $data->meta_description }}</textarea>
                                    </div>
                                </div>
                                @if($key == 'en')
                                    <div class="site-input-groups row">
                                        <label for="" class="col-sm-3 col-label pt-0">{{ __('Page Status') }}<i
                                                data-lucide="info" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Manage Page Visibility"></i></label>
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
                                @endif

                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @php
                $posts = App\Models\Blog::latest()->where('locale',app()->getLocale())->paginate(20);
            @endphp

            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Blog Contents') }}</h3>
                    <div class="card-header-links">
                        <a href="{{ route('admin.page.blog.create') }}"
                            class="card-header-link">{{ __('Add New') }}</a>
                    </div>
                </div>
                <div class="site-card-body">
                    <div class="site-datatable">
                        <table id="dataTable" class="display data-table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Blog Cover') }}</th>
                                <th scope="col">{{ __('Blog Title') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                <tr>
                                    <td>
                                        <img class="avatar avatar-round" src="{{ asset($post->cover)}}" alt="">
                                    </td>
                                    <td>
                                        <strong>{{ $post->title }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('blog-details',$post->id) }}" target="_blank" data-bs-toggle="tooltip" data-bs-original-title="Details Blog" class="round-icon-btn blue-btn">
                                            <i data-lucide="eye"></i>
                                        </a>
                                        <a href="{{ route('admin.page.blog.edit',$post->locale_id) }}" class="round-icon-btn primary-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit Blog">
                                            <i data-lucide="edit-3"></i>
                                        </a>
                                        <button class="round-icon-btn red-btn deleteBlog" type="button" data-id="{{ $post->id }}" data-bs-toggle="tooltip" data-bs-original-title="Delete Blog">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $posts->links() }}
                    </div>

                    <!-- Modal for Delete Blogs -->
                    @include('backend.page.blog.include.__delete_modal')
                    <!-- Modal for Delete Blogs End-->

                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        (function ($) {
            "use strict";

            //Delete Blog modal form open
            $('body').on('click', '.deleteBlog', function () {
                var id = $(this).data('id');
                var url = '{{ route("admin.page.blog.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#deleteBlogForm').attr('action', url)
                $('#deleteBlog').modal('toggle')
            })

        })(jQuery);
    </script>
@endsection
