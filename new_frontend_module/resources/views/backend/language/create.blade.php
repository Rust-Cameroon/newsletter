@extends('backend.layouts.app')
@section('title')
    {{ __('Add new language') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="title">{{ __('Add new language') }}</h3>
                            <div class="card-header-links">
                                <a href="{{ route('admin.language.index') }}"
                                   class="card-header-link">{{ __('Back') }}</a>
                            </div>
                        </div>
                        <div class="site-card-body">
                            <form action="{{ route('admin.language.store') }}" method="post">
                                @csrf
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Language Name:') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="box-input" required name="name"/>
                                    </div>
                                </div>
                                <div class="site-input-groups row">
                                    <label for="" class="col-sm-3 col-label">{{ __('Language Code:') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="box-input" name="code" placeholder="Eg: en" required/>
                                    </div>
                                </div>
                                <div class="row site-input-groups">
                                    <label for="" class="col-sm-3 col-label">{{ __('Default Language:') }}</label>
                                    <div class="col-sm-5">
                                        <div class="site-input-groups">
                                            <div class="switch-field mb-0">
                                                <input
                                                    type="radio"
                                                    id="language-default"
                                                    name="is_default"
                                                    value="1"
                                                />
                                                <label for="language-default">{{ __('Yes') }}</label>
                                                <input
                                                    type="radio"
                                                    id="language-default-no"
                                                    name="is_default"
                                                    value="0"
                                                    checked=""
                                                />
                                                <label for="language-default-no">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row site-input-groups">
                                    <label for="" class="col-sm-3 col-label">{{ __('RTL Support:') }}</label>
                                    <div class="col-sm-5">
                                        <div class="site-input-groups">
                                            <div class="switch-field mb-0">
                                                <input
                                                    type="radio"
                                                    id="rtl-yes"
                                                    name="is_rtl"
                                                    value="1"
                                                />
                                                <label for="rtl-yes">{{ __('Yes') }}</label>
                                                <input
                                                    type="radio"
                                                    id="rtl-no"
                                                    name="is_rtl"
                                                    value="0"
                                                    checked=""
                                                />
                                                <label for="rtl-no">{{ __('No') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row site-input-groups">
                                    <label for="" class="col-sm-3 col-label">{{ __('Language Status:') }}</label>
                                    <div class="col-sm-5">
                                        <div class="site-input-groups">
                                            <div class="switch-field mb-0">
                                                <input
                                                    type="radio"
                                                    id="language-status"
                                                    name="status"
                                                    value="1"
                                                    checked=""
                                                />
                                                <label for="language-status">{{ __('Active') }}</label>
                                                <input
                                                    type="radio"
                                                    id="language-status-no"
                                                    name="status"
                                                    value="0"

                                                />
                                                <label for="language-status-no">{{ __('DeActive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn">{{ __('Save Language') }}</button>
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

