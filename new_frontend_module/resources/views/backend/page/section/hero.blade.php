@extends('backend.layouts.app')
@section('title')
    {{ __('Hero Section') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Hero Section') }}</h2>
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
                            <h3 class="title">{{ __('Contents') }}</h3>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.page.section.section.update') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section_code" value="hero">
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
                                    <label for="" class="col-sm-3 col-label">{{ __('Sub title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sub_title" class="box-input"
                                               value="{{ $data->sub_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hero_title" class="box-input"
                                               value="{{ $data->hero_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Colourfull Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hero_colour_full_title" class="box-input"
                                               value="{{ $data->hero_colour_full_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Right Animate Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hero_right_animate_title" class="box-input"
                                               value="{{ $data->hero_right_animate_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Content') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="hero_content" class="box-input"
                                               value="{{ $data->hero_content }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Button 1') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Button Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="hero_button1_icon" class="box-input"
                                                               value="{{ $data->hero_button1_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Button Label') }}</label>
                                                    <input type="text" name="hero_button1_level" class="box-input"
                                                           value="{{ $data->hero_button1_level }}">
                                                </div>
                                            </div>
                                            @if($key == 'en')
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Button URL') }}</label>
                                                        <div class="site-input-groups">
                                                            <div class="site-input-groups">
                                                                <input type="text" name="hero_button1_url" class="box-input"
                                                                       value="{{ $data->hero_button1_url }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Target') }}</label>
                                                        <div class="site-input-groups">
                                                            <select name="hero_button1_target" class="form-select">
                                                                <option @if($data->hero_button1_target == '_self') selected
                                                                        @endif value="_self">{{ __('Same Tab') }}</option>
                                                                <option @if($data->hero_button1_target == '_blank') selected
                                                                        @endif value="_blank">{{ __('Open In New Tab') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Hero Button 2') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Leave it blank if you don't need this button"></i></label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Button Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">Font Awesome</a></label>
                                                        <input type="text" name="hero_button2_icon" class="box-input"
                                                               value="{{ $data->hero_button2_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Button Label') }}</label>
                                                    <input type="text" name="hero_button2_lavel" class="box-input"
                                                           value="{{ $data->hero_button2_lavel }}">
                                                </div>
                                            </div>
                                            @if($key == 'en')
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Button URL') }}</label>
                                                        <div class="site-input-groups">
                                                            <input type="text" name="hero_button2_url" class="box-input"
                                                                   value="{{ $data->hero_button2_url }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Target') }}</label>
                                                        <div class="site-input-groups">
                                                            <select name="hero_button2_target" class="form-select" id="">
                                                                <option
                                                                    @selected($data->hero_button2_target == '_self')  value="_self">{{ __('Same Tab') }}</option>
                                                                <option
                                                                    @selected($data->hero_button2_target == '_blank') value="_blank">{{ __('Open In New Tab') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($key == 'en')
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Hero Right Image') }} <small>(567x596)</small>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="wrap-custom-file">
                                                <input type="file" name="hero_right_img" id="heroRightImg"
                                                       accept=".gif, .jpg, .png"/>
                                                <label for="heroRightImg" id="hero_right_img" @if($data->hero_right_img) class="file-ok"  style="background-image: url({{ asset($data->hero_right_img) }})" @endif>
                                                    <img class="upload-icon"
                                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                    <span>{{ __('Update Image') }}</span>
                                                </label>
                                                @removeimg($data->hero_right_img,hero_right_img)
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Hero Right Top Image') }} <small>(690x690)</small>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="wrap-custom-file">
                                                <input type="file" name="hero_right_top_img" id="heroRightTopImg"
                                                       accept=".gif, .jpg, .png"/>
                                                <label for="heroRightTopImg" id="hero_right_top_img" @if($data->hero_right_top_img) class="file-ok"
                                                       style="background-image: url({{ asset($data->hero_right_top_img) }})" @endif>
                                                    <img class="upload-icon"
                                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                    <span>{{ __('Update Image') }}</span>
                                                </label>
                                                @removeimg($data->hero_right_top_img,hero_right_top_img)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Hero Left Shape Image') }} <small>(110x120)</small>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="wrap-custom-file">
                                                <input type="file" name="hero_left_shape_img" id="heroTopShapeImg"
                                                       accept=".gif, .jpg, .png"/>
                                                <label for="heroTopShapeImg" id="hero_left_shape_img" @if($data->hero_left_shape_img) class="file-ok"
                                                       style="background-image: url({{ asset($data->hero_left_shape_img) }})" @endif>
                                                    <img class="upload-icon"
                                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                    <span>{{ __('Update Image') }}</span>
                                                </label>
                                                @removeimg($data->hero_left_shape_img,hero_left_shape_img)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-input-groups row">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                            {{ __('Hero Down Shape Image') }} <small>(84x105)</small>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="wrap-custom-file">
                                                <input type="file" name="hero_down_shape_img" id="heroRightDownImg"
                                                       accept=".gif, .jpg, .png"/>
                                                <label for="heroRightDownImg" id="hero_down_shape_img" @if($data->hero_down_shape_img) class="file-ok"
                                                       style="background-image: url({{ asset($data->hero_down_shape_img) }})" @endif>
                                                    <img class="upload-icon"
                                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                    <span>{{ __('Update Image') }}</span>
                                                </label>
                                                @removeimg($data->hero_down_shape_img,hero_down_shape_img)
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


        </div>
    </div>

@endsection
@section('script')
    @include('backend.page.section.include.__section_image_remove')
@endsection

