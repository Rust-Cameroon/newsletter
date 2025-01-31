@extends('backend.setting.index')
@section('setting-title')
    {{ __('SEO Meta Settings') }}
@endsection
@section('setting-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Meta Settings') }}</h3>
                </div>
                <div class="site-card-body">
                    <form action="{{ route('admin.settings.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="section" value="meta">
                        <div class="site-input-groups">
                            <div class="site-input-groups">
                                <div class="col-sm-4 col-label pt-0">{{ __('Meta Description') }}</div>
                                <textarea name="meta_description" class="form-textarea" cols="30" rows="7">{{ setting('meta_description','meta') }}</textarea>
                            </div>
                        </div>
                        <div class="site-input-groups">
                            <div class="site-input-groups">
                                <div class="col-sm-4 col-label pt-0">{{ __('Meta Keywords') }}</div>
                                <input name="meta_keywords" class="box-input" type="text" value="{{ setting('meta_keywords','meta') }}">
                            </div>
                        </div>
                        @include('backend.setting.site_setting.include.form.__close_action')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
