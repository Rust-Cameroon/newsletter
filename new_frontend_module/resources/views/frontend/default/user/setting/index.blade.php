@extends('frontend::layouts.user')
@section('title')
    {{ __('Settings') }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Profile Settings') }}</h3>
            </div>
            <div class="site-card-body">
                <form action="{{ route('user.setting.profile-update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="step-details-form">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="col-xl-4 col-lg-6 col-md-12">
                                    <div class="inputs">
                                        <label class="input-label">{{ __('Avatar:') }}</label>
                                        <div class="wrap-custom-file">
                                            <input
                                                type="file"
                                                name="avatar"
                                                id="avatar"
                                                accept=".gif, .jpg, .png"
                                            />

                                            <label for="avatar" @if($user->avatar && file_exists('assets/'.$user->avatar)) class="file-ok"
                                                    style="background-image: url({{ asset($user->avatar) }})" @endif>
                                                <img
                                                    class="upload-icon"
                                                    src="{{ asset('front/images/icons/upload.svg') }}"
                                                    alt=""
                                                />
                                                <span>{{ __('Update Avatar') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('First Name') }}</label>
                                    <input
                                            type="text"
                                            class="box-input"
                                            name="first_name"
                                            value="{{ $user->first_name }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Last Name') }}</label>
                                    <input
                                        type="text"
                                        class="box-input"
                                        name="last_name"
                                        value="{{ $user->last_name }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Username') }}</label>
                                    <input
                                        type="text"
                                        class="box-input"
                                        name="username"
                                        value="{{ $user->username }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Gender') }}</label>
                                    <select name="gender" class="page-count box-input" required>
                                        @foreach(['Male','Female','Other'] as $gender)
                                            <option value="{{$gender}}"  @selected($user->gender == $gender)>{{$gender}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Date of Birth') }}</label>
                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        class="box-input"
                                        value="{{ $user->date_of_birth }}"
                                    />
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Email Address') }}</label>
                                    <input type="email" disabled class="box-input disabled"
                                            value="{{ $user->email }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Phone') }}</label>

                                    <input
                                        type="text"
                                        class="box-input"
                                        name="phone"
                                        value="{{ $user->phone }}"
                                    />
                                </div>

                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Country') }}</label>
                                    <input
                                        type="text"
                                        class="box-input disabled"
                                        value="{{ $user->country }}"
                                        disabled
                                    />
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('City') }}</label>
                                    <input
                                        type="text"
                                        class="box-input"
                                        name="city"
                                        value="{{ $user->city }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Zip') }}</label>
                                    <input
                                        type="text"
                                        class="box-input"
                                        name="zip_code"
                                        value="{{ $user->zip_code }}"
                                    />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Address') }}</label>
                                    <input
                                        type="text"
                                        class="box-input"
                                        name="address"
                                        value="{{ $user->address }}"
                                    />

                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="inputs">
                                    <label class="form-label">{{ __('Joining Date') }}</label>
                                    <input
                                        type="text"
                                        class="box-input disabled"
                                        value="{{ $user->created_at }}"
                                        disabled
                                    />
                                </div>
                            </div>

                            <div class="col-xl-6 col-md-12">
                                <button type="submit" class="site-btn polis-btn">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

