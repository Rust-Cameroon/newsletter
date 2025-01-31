@extends('backend.setting.index')
@section('setting-title')
    {{ __('Mail Settings') }}
@endsection
@section('title')
    {{ __('Mail Settings') }}
@endsection
@section('setting-content')

    <div class="col-xl-8 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Mail Settings') }}</h3>
                <div class="card-header-links">
                    <a data-bs-toggle="modal" data-bs-target="#mailConnection" href="javascript:void(0);" class="card-header-link"> <i data-lucide="mail-check"></i> {{ __('Connection Check') }}</a>
                </div>
            </div>
            <div class="site-card-body">
                <form action="{{ route('admin.settings.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="section" value="mail">
                    <div class="site-input-groups row mb-0">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                            {{ __('Mail Setting') }}
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="form-row row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for=""
                                               class="box-input-label col-label">{{ __('Email From Name') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="email_from_name"
                                            value="{{ setting('email_from_name','mail') }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for=""
                                               class="box-input-label col-label">{{ __('Email From Address') }}</label>
                                        <input
                                            type="email"
                                            class="box-input"
                                            name="email_from_address"
                                            value="{{ setting('email_from_address','mail') }}"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label pt-0">
                            {{ __('Mailing Driver') }}
                        </div>

                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="site-input-groups">

                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="mailing_driver"
                                        id="smtp"
                                        value="smtp"
                                        checked=""
                                    />
                                    <label class="form-check-label col-label pt-0" for="smtp">
                                        {{ __('SMTP') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-label">
                            {{ __('Configuration') }}
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="form-row row">
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Mail Username') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="mail_username"
                                            value="{{ setting('mail_username','mail') }}"
                                            required=""
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Mail Password') }}</label>
                                        <input
                                            type="password"
                                            class="box-input"
                                            name="mail_password"
                                            value="{{   !config('app.demo') ? setting('mail_password','mail') : 'demo-mode' }}"
                                            required=""
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('SMTP Host') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="mail_host"
                                            value="{{ setting('mail_host','mail') }}"
                                            required=""
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('SMTP Port') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="mail_port"
                                            value="{{ setting('mail_port','mail') }}"
                                            required=""
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-sm-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('SMTP Secure') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            name="mail_secure"
                                            value="{{ setting('mail_secure','mail') }}"
                                            required=""
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="offset-sm-3 col-sm-9 col-12">
                            <button type="submit" class="site-btn-sm primary-btn w-100">
                                {{ __(' Save Changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{--mail connection test--}}

    <div
        class="modal fade"
        id="mailConnection"
        tabindex="-1"
        aria-labelledby="mailConnectionLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content site-table-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="mailConnectionLabel">
                        {{ __('SMTP Connection') }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.settings.mail.connection.test') }}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Your Email:') }}</label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="box-input mb-0"
                                        required=""
                                    />
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" class="site-btn primary-btn w-100">
                                    {{ __('Check Now') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
