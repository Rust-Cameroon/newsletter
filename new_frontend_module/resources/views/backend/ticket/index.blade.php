@extends('backend.layouts.app')
@section('title')
    {{ __('All Support Tickets') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="page-title">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="title-content">
                            <h2 class="title">{{ __('All Support Tickets') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12">
                    <div class="site-card-body">
                        <div class="site-table table-responsive">
                            @include('backend.ticket.include.__filter', ['status' => true])
                            <table class="table">
                                <thead>
                                <tr>
                                    @include('backend.filter.th',['label' => 'Ticket Name','field' => 'title'])
                                    @include('backend.filter.th',['label' => 'Opening Date','field' => 'created_at'])
                                    @include('backend.filter.th',['label' => 'Status','field' => 'status'])
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($tickets as $ticket)
                                        <tr>
                                            <td>
                                                @include('backend.ticket.include.__name', ['user_id' => $ticket->user_id, 'title' => $ticket->title, 'uuid' => $ticket->uuid])
                                            </td>
                                            <td>
                                                {{ safe($ticket->created_at) }}
                                            </td>
                                            <td>
                                                @include('backend.ticket.include.__status', ['status' => $ticket->status])
                                            </td>
                                            <td>
                                                @include('backend.ticket.include.__action', ['uuid' => $ticket->uuid])
                                            </td>
                                        </tr>
                                    @empty
                                    <td colspan="4" class="text-center">{{ __('No Data Found!') }}</td>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $tickets->links('backend.include.__pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


