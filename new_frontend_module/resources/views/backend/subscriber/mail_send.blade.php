@extends('backend.layouts.app')
@section('title')
    {{ __('Send Email to All') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Send Email to All Subscriber') }}</h2>
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
                            <form action="{{ route('admin.mail.send.subscriber.now') }}" method="post">
                                @csrf
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Subject:') }}</label>
                                    <input type="text" name="subject" class="box-input mb-0" required=""/>
                                </div>
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Email Details') }}</label>
                                    <textarea name="message" class="form-textarea"></textarea>
                                </div>

                                <div class="action-btns">
                                    <button type="submit" class="site-btn-sm primary-btn me-2">
                                        <i data-lucide="send"></i>
                                        {{ __('Send Email') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

