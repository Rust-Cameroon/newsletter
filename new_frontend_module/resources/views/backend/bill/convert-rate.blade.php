@extends('backend.layouts.app')
@section('title')
{{ __('Convert Rate') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Convert Rate') }}</h2>
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
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-3 col-xl-3">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Method:') }}</label>
                                        <select name="method" class="form-select">
                                            <option value="" selected disabled>{{ __('Select Method') }}</option>
                                            @foreach ($methods as $method)
                                            <option value="{{ strtolower($method->name) }}" @selected(request('method') == strtolower($method->name))>{{ __($method->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xl-3">

                                    <button type="submit" name="type" value="get_currencies" class="site-btn-sm primary-btn mt-4">
                                        <i data-lucide="search"></i>
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($currencies !== null)
            <div class="col-xl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="title">{{ __('Set Conversion Rate') }}</h3>
                    </div>
                    <div class="site-card-body">
                        <form action="{{ route('admin.bill.save.rate') }}" method="post">
                            @csrf
                            <input type="hidden" name="method" value="{{ request('method') }}">
                            <div class="row">
                                @foreach ($currencies as $c)
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <div class="input-group joint-input">
                                            <span class="input-group-text">1 {{ $currency }} = </span>
                                            <input type="number" name="rate[{{ $c }}]" class="form-control" min="1" value="{{ isset($rates[$c]) ? $rates[$c] : '' }}"/>
                                            <span class="input-group-text">{{ $c }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button class="site-btn-sm primary-btn" type="submit"><i data-lucide="check"></i> {{ __('Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
