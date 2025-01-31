@extends('backend.layouts.app')
@section('title')
    {{ __('Application Details') }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('Application Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title">{{ __('Server Info') }}</h4>
                        </div>
                        <div class="site-card-body p-0">
                            <div class="site-table table-responsive mb-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Required Version') }}</th>
                                            <th>{{ __('Current Version') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>{{ __('php Version') }}</strong></td>
                                            <td>8.1+</td>
                                            <td>{{ substr(PHP_VERSION,0,3) }}</td>
                                            <td>{!! substr(PHP_VERSION,0,3) >= 8.1 ? $success : $error !!} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('Laravel Version') }}</strong></td>
                                            <td>---</td>
                                            <td>{{ app()->version() }}</td>
                                            <td>{!! $success !!} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('MySQL Version') }}</strong></td>
                                            <td>5.7+</td>
                                            <td>{{ substr($mySqlVersion,0,3) }}</td>
                                            <td>{!! substr($mySqlVersion,0,3) >= 5.7 ? $success : $error !!} </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ __('DigiBank Version') }}</strong></td>
                                            <td>---</td>
                                            <td>{{ config('app.version') }}</td>
                                            <td>{!! $success !!} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title">{{ __('php.ini Info') }}</h4>
                        </div>
                        <div class="site-card-body p-0">
                            <div class="site-table table-responsive mb-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Config Name') }}</th>
                                            <th>{{ __('Recommended Value') }}</th>
                                            <th>{{ __('Current Value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>file_uploads</td>
                                            <td>
                                                <strong class="site-badge primary">On</strong>
                                            </td>
                                            <td>
                                                @if(ini_get('file_uploads') == 1)
                                                <strong class="site-badge primary">On</strong>
                                                @else
                                                <strong class="site-badge danger">Off</strong>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>max_file_uploads</td>
                                            <td>
                                                <strong>10+</strong>
                                            </td>
                                            <td>
                                                <strong>{{ ini_get('max_file_uploads') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>upload_max_filesize</td>
                                            <td>
                                                <strong>128M+</strong>
                                            </td>
                                            <td>
                                                <strong>{{ ini_get('upload_max_filesize') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>max_execution_time</td>
                                            <td>
                                                <strong>256+</strong>
                                            </td>
                                            <td>
                                                <strong>{{ ini_get('max_execution_time') == '-1' ? 'Unlimited' : ini_get('max_execution_time') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>memory_limit</td>
                                            <td>
                                                <strong>128M+</strong>
                                            </td>
                                            <td>
                                                <strong>{{ ini_get('memory_limit') == '-1' ? 'Unlimited' : ini_get('memory_limit') }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="site-card">
                        <div class="site-card-header">
                            <h4 class="title">{{ __('PHP Extensions Info') }}</h4>
                        </div>
                        <div class="site-card-body p-0">
                            <div class="site-table table-responsive mb-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Extension Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($required_extensions as $extension)
                                        <tr>
                                            <td><strong>{{ $extension }}</strong></td>
                                            <td>{!! in_array($extension,get_loaded_extensions()) ? $success : $error !!} </td>
                                        </tr>
                                        @endforeach

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

