@if(request('tab') == 'ticket')
<div
    @class([
        'tab-pane fade',
        'show active' => request('tab') == 'ticket'
    ])
    id="pills-ticket"
    role="tabpanel"
    aria-labelledby="pills-ticket-tab"
>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h4 class="title">{{ __('Support Tickets') }}</h4>
                </div>
                <div class="site-card-body table-responsive">
                    <div class="site-table">
                        <div class="table-filter">
                            <form action="" method="get">
                                <input type="hidden" name="tab" value="ticket">
                                <div class="filter d-flex">
                                    <div class="search">
                                        <label for="">{{ __('Search:') }}</label>
                                        <input type="text" name="query" value="{{ request('query') }}"/>
                                    </div>
                                    <button class="apply-btn" type="submit"><i data-lucide="search"></i>{{ __('Search') }}</button>
                                </div>
                            </form>
                        </div>
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
                                @forelse ($tickets as $ticket)
                                <tr>
                                    <td>
                                        @include('backend.ticket.include.__name',[ 'title' => $ticket->title,'uuid' => $ticket->uuid,'user_id' => $ticket->user_id])
                                    </td>
                                    <td>{{ $ticket->created_at }}</td>
                                    <td>
                                        @include('backend.ticket.include.__status',['status' => $ticket->status])
                                    </td>
                                    <td>
                                        @include('backend.ticket.include.__action',['uuid' => $ticket->uuid])
                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">{{ __('No Data Found!') }}</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
