@extends('backend.layouts.app')
@section('title')
    {{ __('Video Section') }}
@endsection
@section('content')

    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Video Section') }}</h2>
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
                            <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section_code" value="videosection">
                                <input type="hidden" name="section_locale" value="{{$key}}">

                                @if($key == 'en')
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
                                @endif

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Small Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="small_title" class="box-input"
                                               value="{{ $data->small_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Big Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="big_title" class="box-input" value="{{ $data->big_title }}">
                                    </div>
                                </div>

                                @if($key == 'en')
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Video Link') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="video_link" class="box-input" value="{{ $data->video_link }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('Thumbnail') }} <small>(1256x740)</small>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="thumbnail_img" id="thumbanilImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="thumbanilImg" id="thumbnail_img" @if($data->thumbnail_img)  class="file-ok"
                                                   style="background-image: url({{ asset($data->thumbnail_img) }})" @endif>
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                            @removeimg($data->thumbnail_img,thumbnail_img)
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('Left Shape Image') }} <small>(114x141)</small>
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="left_shape_img" id="leftShapeImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="leftShapeImg" id="left_shape_img" @if($data->left_shape_img)  class="file-ok"
                                                   style="background-image: url({{ asset($data->left_shape_img) }})" @endif>
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                            @removeimg($data->left_shape_img,left_shape_img)
                                        </div>
                                    </div>
                                </div>
                            @endif
                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="site-btn-sm primary-btn w-100">{{ __('Save Changes') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
