@extends('backend.layouts.app')
@section('title')
    {{ __('Contact Us') }}
@endsection
@section('content')

    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Contact Page') }}</h2>
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
                                <input type="hidden" name="page_code" value="contact">
                                <input type="hidden" name="page_locale" value="{{ $key }}">
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
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Title Small') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title_small" class="box-input"
                                               value="{{ $data->title_small }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Title Big') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title_big" class="box-input"
                                               value="{{ $data->title_big }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget One') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="widget_one_icon" class="box-input"
                                                               value="{{ $data->widget_one_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Title') }}</label>
                                                    <input type="text" name="widget_one_title" class="box-input"
                                                           value="{{ $data->widget_one_title }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for="" class="box-input-label">{{ __('Description') }}</label>
                                                    <div class="site-input-groups">
                                                        <div class="site-input-groups">
                                                            <textarea name="widget_one_description" cols="30" rows="5" class="form-textarea">{{ $data->widget_one_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget Two') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="widget_two_icon" class="box-input"
                                                               value="{{ $data->widget_two_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Title') }}</label>
                                                    <input type="text" name="widget_two_title" class="box-input"
                                                           value="{{ $data->widget_two_title }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for="" class="box-input-label">{{ __('Description') }}</label>
                                                    <div class="site-input-groups">
                                                        <div class="site-input-groups">
                                                            <textarea name="widget_two_description" cols="30" rows="5" class="form-textarea">{{ $data->widget_two_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Widget Three') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="widget_three_icon" class="box-input"
                                                               value="{{ $data->widget_three_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Title') }}</label>
                                                    <input type="text" name="widget_three_title" class="box-input"
                                                           value="{{ $data->widget_three_title }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for="" class="box-input-label">{{ __('Description') }}</label>
                                                    <div class="site-input-groups">
                                                        <div class="site-input-groups">
                                                            <textarea name="widget_three_description" cols="30" rows="5" class="form-textarea">{{ $data->widget_three_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Form Area Title') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="form_title" class="box-input"
                                               value="{{ $data->form_title }}">
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Form Area Description') }}</label>
                                    <div class="col-sm-9">
                                        <textarea name="form_description" cols="30" rows="5" class="form-textarea">{{ $data->form_description }}</textarea>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact One') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="contact_one_icon" class="box-input"
                                                               value="{{ $data->contact_one_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Title') }}</label>
                                                    <input type="text" name="contact_one_title" class="box-input"
                                                           value="{{ $data->contact_one_title }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for="" class="box-input-label">{{ __('Value') }}</label>
                                                    <div class="site-input-groups">
                                                        <div class="site-input-groups">
                                                            <input type="text" name="contact_one_value" class="box-input"
                                                                   value="{{ $data->contact_one_value }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Contact Two') }}</label>
                                    <div class="col-sm-9">
                                        <div class="form-row">
                                            @if($key == 'en')
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="site-input-groups">
                                                        <label for="" class="box-input-label">{{ __('Icon') }} <a
                                                                class="link" href="https://fontawesome.com/icons"
                                                                target="_blank">{{ __('Font Awesome') }}</a></label>
                                                        <input type="text" name="contact_two_icon" class="box-input"
                                                               value="{{ $data->contact_two_icon }}">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for=""
                                                           class="box-input-label">{{ __('Title') }}</label>
                                                    <input type="text" name="contact_two_title" class="box-input"
                                                           value="{{ $data->contact_two_title }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="site-input-groups">
                                                    <label for="" class="box-input-label">{{ __('Value') }}</label>
                                                    <div class="site-input-groups">
                                                        <div class="site-input-groups">
                                                            <input type="text" name="contact_two_value" class="box-input"
                                                                   value="{{ $data->contact_two_value }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($key == 'en')
                                <div class="site-input-groups row">
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                                        {{ __('Form Background Image') }}
                                    </div>
                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                        <div class="wrap-custom-file">
                                            <input type="file" name="form_background_img" id="bgImg"
                                                   accept=".gif, .jpg, .png"/>
                                            <label for="bgImg" id="form_background_img" @if($data->form_background_img) class="file-ok"  style="background-image: url({{ asset($data->form_background_img) }})" @endif>
                                                <img class="upload-icon"
                                                     src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                                <span>{{ __('Update Image') }}</span>
                                            </label>
                                            @removeimg($data->form_background_img,form_background_img)
                                        </div>
                                    </div>
                                </div>
                                @endif
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
        </div>
    </div>

@endsection
