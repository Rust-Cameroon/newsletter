@extends('backend.layouts.app')
@section('title')
    {{ __('Change Password') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Change Password') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form method="post" action="{{ route('admin.password-update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Old Password:') }}</label>
                                            <input type="password" name="current_password" class="box-input"
                                                   required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('New Password:') }}</label>
                                            <input type="password" name="new_password" class="box-input" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Confirm Password:') }}</label>
                                            <input type="password" name="new_confirm_password" class="box-input"
                                                   required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <button type="submit"
                                                class="site-btn-sm primary-btn w-100 centered">{{ __('Change Password') }}</button>
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
