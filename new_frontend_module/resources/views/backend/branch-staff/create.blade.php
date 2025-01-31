@extends('backend.layouts.app')
@section('title')
    {{ __('Add New Staff') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="title-content">
                            <h2 class="title">{{ __('Add New Staff') }}</h2>
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
                            <form action="{{route('admin.branch-staff.store')}}" method="post"
                                  class="row">
                                @csrf
                                <div class="col-xl-6 schema-name">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Name:') }}</label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="box-input"
                                            placeholder="{{ __('Name') }}"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Email:') }}</label>
                                        <input
                                            type="email"
                                            class="box-input"
                                            placeholder="{{ __('Email') }}"
                                            name="email"
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
                                            placeholder="{{ __('Phone') }}"
                                            name="phone"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Password:') }}</label>
                                        <input
                                            type="password"
                                            class="box-input"
                                            placeholder="{{ __('Password') }}"
                                            name="password"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Select Role:') }}</label>
                                        <select name="role" class="form-select">
                                            @foreach($roles as $role)
                                            <option value="{{$role->name}}">{{ str_replace('-', ' ', $role->name) }}</option>
                                            @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Select Branch:') }}</label>
                                        <select name="branch" class="form-select">
                                            @foreach($branch as $bran)
                                            <option value="{{$bran->id}}">{{ str_replace('-', ' ', $bran->name) }}</option>
                                            @endforeach
                                        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xl-12 schema-badge">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Address:') }}</label>
                                        <textarea name="address" placeholder="{{ __('Address') }}" class="form-textarea" cols="30"
                                                  rows="3"></textarea>
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
                                            />
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input
                                                type="radio"
                                                id="radio-six"
                                                name="status"
                                                value="0"
                                            />
                                            <label for="radio-six">{{ __('Deactivate') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <button type="submit" class="site-btn-sm primary-btn w-100">
                                        {{ __('Add New Staff') }}
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
