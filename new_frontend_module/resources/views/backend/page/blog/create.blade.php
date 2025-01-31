@extends('backend.layouts.app')
@section('title')
    {{ __('Add New Blog') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add New Blog') }}</h2>
                            <a href="{{ route('admin.page.edit','blog') }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Details') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.blog.store') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">Blog Title<i data-lucide="info"
                                                                                          data-bs-toggle="tooltip"
                                                                                          title=""
                                                                                          data-bs-original-title="There will be blog title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" placeholder="Blog Title"
                                               required="">
                                    </div>
                                </div>

                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('Blog Cover') }}
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="cover" id="cover" accept=".gif, .jpg, .png"/>
                                            <label for="cover">
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Upload Cover') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="site-input-groups row mb-0">
                                    <label for="" class="col-sm-3 col-label">{{ __('Blog Details') }}<i data-lucide="info"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title=""
                                                                                                        data-bs-original-title="There will be blog title"></i></label>
                                    <div class="col-sm-9">
                                        <div class="site-input-groups fw-normal">
                                            <div class="site-editor">
                                                <textarea class="summernote" name="details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
            </div>
        </div>
    </div>
@endsection
