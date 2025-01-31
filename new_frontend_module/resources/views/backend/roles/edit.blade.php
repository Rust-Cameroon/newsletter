@extends('backend.layouts.app')
@section('title')
    {{ __('Update Role') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Update Role') }}</h2>
                            <a href="{{ url()->previous() }}" class="title-btn"><i
                                    data-lucide="corner-down-left"></i>{{ __('Back') }}</a>
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
                            <div class="row">
                                <form action="{{route('admin.roles.update',$role->id)}}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="col-xl-12">
                                        <div class="site-input-groups">
                                            <label for="" class="box-input-label">{{ __('Role Name') }}</label>
                                            <input type="text" class="box-input" required="" name="name"
                                                   value="{{$role->name}}"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="site-card">
                                            <div class="site-card-header">
                                                <h3 class="title mb-0">{{ __('All Permissions') }}</h3>
                                            </div>
                                            <div class="site-card-body">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="role-cat-items">
                                                            <div class="accordion">
                                                                @foreach($permissions as $category => $permission)

                                                                    @php
                                                                        $checked = !empty(array_intersect($rolePermissions, $permission->pluck('id')->toArray()));
                                                                    @endphp

                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingOne">
                                                                            <button
                                                                                class="accordion-button @if(!$checked) collapsed @endif"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#{{ str_replace(' ','',$category) }}"
                                                                                aria-expanded="true"
                                                                                aria-controls="{{$category}}">
                                                                                <span class="icon"><i
                                                                                        data-lucide="check"></i></span>{{$category}}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="{{str_replace(' ','',$category)}}"
                                                                             class="accordion-collapse collapse @if($checked) show @endif"
                                                                             aria-labelledby="headingOne">
                                                                            <div class="accordion-body">
                                                                                <div class="row">
                                                                                    @foreach($permission as $raw)
                                                                                        <div
                                                                                            class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                                                            <div
                                                                                                class="form-check form-switch role-permission-switch">
                                                                                                <label
                                                                                                    class="switch-label"
                                                                                                    for="{{$raw->name}}">{{ ucwords(str_replace('-', ' ', $raw->name)) }}</label>
                                                                                                <input
                                                                                                    class="form-check-input big"
                                                                                                    type="checkbox"
                                                                                                    role="switch"
                                                                                                    id="{{$raw->name}}"
                                                                                                    name="permission[]"
                                                                                                    value="{{$raw->id}}"
                                                                                                    @if(in_array($raw->id, $rolePermissions)) checked @endif
                                                                                                />
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <button class="site-btn primary-btn" type="submit"><i
                                                                data-lucide="check"></i>{{ __('Save Changes') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
