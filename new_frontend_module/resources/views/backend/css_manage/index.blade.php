@extends('backend.layouts.app')
@section('style')
    <link href="{{ asset('backend/css/codemirror.css') }}" rel='stylesheet'>
    <link href="{{ asset('backend/css/ayu-dark.css') }}" rel='stylesheet'>
@endsection
@section('title')
    {{ __('Add Custom CSS') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add Custom CSS') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <div class="paragraph mb-4"><i data-lucide="alert-triangle"></i>You can add <strong>Custom CSS</strong> to write the css below and it will effect on the <strong>User Front End Pages</strong></div>
                            <form action="{{ route('admin.custom-css.update') }}" method="post">
                                @csrf
                                <div class="site-input-groups">
                                    <textarea name="custom_css" class="form-textarea editorContainer">{{ $customCss }}</textarea>
                                </div>
                                <button type="submit" class="site-btn-sm primary-btn">
                                    {{ __('Save Changes') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/js/codemirror.js') }}"></script>
    <script src="{{ asset('backend/js/code-css.js') }}"></script>
    <script>
        ( () => {
            'use strict';
            var editorContainer = document.querySelector('.editorContainer')

            var editor = CodeMirror.fromTextArea(editorContainer, {
                lineNumbers: true,
                mode: 'css',
                theme: 'ayu-dark',
            });
        } )();
    </script>
@endsection
