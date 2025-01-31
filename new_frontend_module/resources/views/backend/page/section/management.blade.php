@extends('backend.layouts.app')
@section('title')
{{ __('Landing Section Management') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Landing Section Management') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Manage Section Order') }}</h3>
            </div>
            <form action="{{ route('admin.page.section.management.update') }}" method="post">
                @csrf
                <div class="site-card-body">
                    <div class="site-table table-responsive mb-0">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Section') }}</th>
                                <th scope="col">{{ __('Order') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section)
                                <tr>
                                    <td>
                                        <strong>{{ $section->name }}</strong>
                                    </td>
                                    <td>
                                        <div class="site-input-groups">
                                            <input type="text" name="section_order[{{ $section->code }}]" class="box-input"
                                            value="{{ $section->short }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="site-card-footer">
                    <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
