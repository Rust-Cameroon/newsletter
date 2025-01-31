@extends('backend.layouts.app')
@section('title')
    {{ __('Edit New Branch') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Edit New Branch') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <form action="{{route('admin.branch.update', $branch->id)}}" method="post" enctype="multipart/form-data"
                                  class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-xl-6 schema-name">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Branch Name:') }}</label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="box-input"
                                            placeholder="{{ __('Branch Name') }}"
                                            value="{{ $branch->name }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Branch Code:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Branch Code') }}"
                                            name="code"
                                            value="{{ $branch->code }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Routing Number:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Routing Number') }}"
                                            name="routing_number"
                                            value="{{ $branch->routing_number }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Swift Code:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Swift Code') }}"
                                            name="swift_code"
                                            value="{{ $branch->swift_code }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Phone:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Phone Number') }}"
                                            value="{{ $branch->phone }}"
                                            name="phone"
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Email:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Email Address') }}"
                                            value="{{ $branch->email }}"
                                            name="email"
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Mobile:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Mobile Number') }}"
                                            value="{{ $branch->mobile }}"
                                            name="mobile"
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Fax:') }}</label>
                                        <input
                                            type="text"
                                            class="box-input"
                                            placeholder="{{ __('Fax') }}"
                                            value="{{ $branch->fax }}"
                                            name="fax"
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-12 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Address:') }}</label>
                                        <textarea name="address" placeholder="{{ __('Address') }}" class="form-textarea" cols="30"
                                                  rows="3">
                                            {{ $branch->address }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Google Map Location:') }}</label>
                                        <textarea name="map_location" placeholder="{{ __('Google Map Link') }}" class="form-textarea" cols="30"
                                                  rows="3">
                                            {{ $branch->map_location }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status:') }}</label>
                                        <div class="switch-field same-type">
                                            <input
                                                type="radio"
                                                id="radio-five"
                                                name="status"
                                                checked=""
                                                value="1"
                                                @if($branch->status) checked @endif
                                            />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input
                                                type="radio"
                                                id="radio-six"
                                                name="status"
                                                value="0"
                                                @if(!$branch->status) checked @endif
                                            />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <button type="submit" class="site-btn-sm primary-btn w-100">
                                        {{ __('Update Branch') }}
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
