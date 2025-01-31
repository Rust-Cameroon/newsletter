@extends('backend.layouts.app')
@section('title')
    {{ __('Manage Roles') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Manage Roles') }}</h2>
                            @can('role-create')
                                <a href="{{route('admin.roles.create')}}" class="title-btn"><i
                                        data-lucide="plus-circle"></i>{{ __('Add New Role') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body centered">
                            <div class="site-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('#') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($roles as  $role)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td><strong>{{ str_replace('-',' ',$role->name) }}</strong></td>
                                            <td>
                                                @if($role->name == 'Super-Admin')
                                                    <button class="site-btn-xs red-btn table-btn"><i
                                                            data-lucide="alert-triangle"></i>{{ __('Not Editable') }}
                                                    </button>
                                                @else
                                                    @can('role-edit')
                                                        <a href="{{route('admin.roles.edit',$role->id)}}"
                                                           class="site-btn-xs primary-btn table-btn"><i
                                                                data-lucide="edit-3"></i>{{ __('Edit Permission') }}</a>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="3" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
