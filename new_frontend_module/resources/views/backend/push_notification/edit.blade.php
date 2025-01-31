@extends('backend.layouts.app')
@section('title')
    {{ __('Edit Email Template') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title"> {{ __('Edit') }} {{  $template->name }} {{ __('Template') }}</h3>
                            <div class="card-header-links">
                                <a href="{{ route('admin.template.notification.index') }}"
                                   class="card-header-link">{{ __('Back') }}</a>
                            </div>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.template.notification.template-update') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $template->id }}">

                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Title') }}<i data-lucide="info"
                                                                                                 data-bs-toggle="tooltip"
                                                                                                 title="Leave it blank if you don't need the title"
                                                                                                 data-bs-original-title="Leave it blank if you don't need the title"></i></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="title" class="box-input" value="{{ $template->title }}"
                                               required/>
                                    </div>
                                </div>


                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Message Body') }}<i data-lucide="info"
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        title=""
                                                                                                        data-bs-original-title="Write the main Messages here"></i></label>
                                    <div class="col-sm-9">
                                        <textarea name="message_body" class="form-textarea" cols="30"
                                                  rows="8">{{ br2nl($template->message_body) }}</textarea>
                                                  <p class="paragraph mb-0 mt-2"><i
                                                    data-lucide="alert-triangle"></i>{{ __('The Shortcuts you can use') }}
                                                <strong>{{ implode(", ",json_decode($template->short_codes)) }}</strong></p>
                                    </div>
                                </div>






                                <div class="row site-input-groups">
                                    <label for="" class="col-sm-3 col-label pt-0">{{ __('Template Status') }}<i
                                            data-lucide="info" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Template Status"></i></label>
                                    <div class="col-sm-5">
                                        <div class="site-input-groups mb-0">
                                            <div class="switch-field mb-0">
                                                <input
                                                    type="radio"
                                                    id="template_status_enable"
                                                    name="status"
                                                    value="1"
                                                    @checked($template->status)
                                                />
                                                <label for="template_status_enable">{{ __('Enable') }}</label>
                                                <input
                                                    type="radio"
                                                    id="template_status_disable"
                                                    name="status"
                                                    value="0"
                                                    @checked(!$template->status)
                                                />
                                                <label for="template_status_disable">{{ __('Disable') }}</label>
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

