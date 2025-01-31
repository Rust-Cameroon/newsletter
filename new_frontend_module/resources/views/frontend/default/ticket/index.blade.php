@extends('frontend::layouts.user')
@section('title')
    {{ __('My Ticket List') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('front/css/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('My Ticket List') }}</h3>
                    <div class="card-header-links">
                        <a href="#"
                            class="card-header-link"
                            data-bs-toggle="modal"
                            data-bs-target="#openTicket"
                            >
                            <i data-lucide='plus-circle'></i> {{ __('Create Ticket') }}
                        </a>
                    </div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
                    <form id="filter-form">
                        <div class="table-filter">
                            <div class="filter">
                                <div class="single-f-box">
                                    <label for="">{{ __('Subject') }}</label>
                                    <input class="search" type="text" name="subject" value="{{ request('subject') }}" autocomplete="off"/>
                                </div>
                                <div class="single-f-box">
                                    <label for="">{{ __('Date') }}</label>
                                    <input type="text" name="daterange" value="{{ request('daterange') }}" autocomplete="off" />
                                </div>
                                <button class="apply-btn me-2" name="filter">
                                    <i data-lucide="filter"></i>{{ __('Filter') }}
                                </button>
                                @if(request()->has('filter'))
                                <button type="button" class="apply-btn bg-danger reset-filter">
                                    <i data-lucide="x"></i>{{ __('Reset Filter') }}
                                </button>
                                @endif
                            </div>
                            <div class="filter">
                                <div class="single-f-box w-auto ms-4 me-0">
                                    <label for="">{{ __('Entries') }}</label>
                                    <select name="limit" class="nice-select page-count" onchange="$('#filter-form').submit()">
                                        <option value="15" @selected(request('limit',15) == '15')>15</option>
                                        <option value="30" @selected(request('limit') == '30')>30</option>
                                        <option value="50" @selected(request('limit') == '50')>50</option>
                                        <option value="100" @selected(request('limit') == '100')>100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="site-custom-table">
                        <div class="contents">
                            <div class="site-table-list site-table-head">
                                <div class="site-table-col">{{ __('Ticket') }}</div>
                                <div class="site-table-col">{{ __('Precedence') }}</div>
                                <div class="site-table-col">{{ __('Last Open') }}</div>
                                <div class="site-table-col">{{ __('Status') }}</div>
                                <div class="site-table-col">{{ __('Action') }}</div>
                            </div>
                            @foreach ($tickets as $ticket)
                            <div class="site-table-list">
                                <div class="site-table-col">
                                    <div class="description">
                                        <div class="event-icon">
                                            <i data-lucide="message-circle"></i> 
                                        </div>
                                        <div class="content">
                                            <div class="title">
                                                <a href="{{ route('user.ticket.show',$ticket->uuid) }}">
                                                    [{{ __('Ticket') }} - {{ $ticket->uuid }}] {{ $ticket->title }}
                                                </a>
                                            </div>
                                            <div class="date">{{ $ticket->created_at }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="site-table-col">
                                    @if($ticket->priority == 'low')
                                    <div class="type site-badge badge-pending">{{ $ticket->priority }}</div>
                                    @elseif($ticket->priority == 'high')
                                    <div class="type site-badge badge-primary">{{ $ticket->priority }}</div>
                                    @else
                                    <div class="type site-badge badge-success">{{ $ticket->priority }}</div>
                                    @endif
                                </div>
                                <div class="site-table-col">
                                    <div class="trx fw-bold">{{ $ticket->messages->last()?->created_at->diffForHumans() ?? '--' }}</div>
                                </div>
                                <div class="site-table-col">
                                    @if($ticket->isOpen())
                                        <span class="ms-2 status site-badge badge-primary">{{ __('Opened') }}</span>
                                    @elseif($ticket->isClosed())
                                        <span class="ms-2 status site-badge badge-failed">{{ __('Closed') }}</span>
                                    @endif
                                </div>
                                <div class="site-table-col">
                                    <div class="action">
                                        <a href="{{ route('user.ticket.show',$ticket->uuid) }}" class="icon-btn"><i data-lucide="eye"></i>{{ __('View') }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{ $tickets->links() }}
                        </div>

                        @if(count($tickets) == 0)
                        <div class="no-data-found">{{ __('No Data Found') }}</div>
                        @endif
                    </div>

                    <!-- Modal for open Ticket-->
                    <div class="modal fade" id="openTicket" tabindex="-1" aria-labelledby="openTicketModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content site-table-modal">
                                <div class="modal-body popup-body"> <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> </button>
                                    <div class="popup-body-text">
                                        <div class="title">{{ __('Open a New Ticket') }}</div>

                                        <form action="{{ route('user.ticket.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="step-details-form">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="inputs">
                                                            <label for="" class="input-label">{{ __('Subject') }}<span class="required">*</span></label>
                                                            <input type="text" class="box-input" name="title" />
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="inputs">
                                                            <label for="" class="input-label">{{ __('Precedence') }}<span class="required">*</span></label>
                                                            <select class="add-priority box-input page-count" name="priority">
                                                                <option selected disabled value="">{{ __('Select Precedence') }}</option>
                                                                <option value="low">{{ __('Low') }}</option>
                                                                <option value="medium">{{ __('Medium') }}</option>
                                                                <option value="high">{{ __('High') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="inputs">
                                                            <label for="">{{ __('Your Message') }}<span class="required">*</span></label>
                                                            <textarea class="box-textarea" name="message" rows="6"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">

                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                            <div class="add-attachment"> <a href="javascript:void(0)" onclick="addNewAttachment()">
                                                                <i data-lucide="plus-circle"></i>{{ __('Add') }}</a>
                                                            </div>
                                                        </div>

                                                        <div id="attachments">
                                                            <div class="wrap-custom-file">
                                                                <input type="file" name="attachments[]" id="attach" accept=".jpeg, .jpg, .png" />
                                                                <label for="attach">
                                                                    <img class="upload-icon" src="{{ asset('front/images/icons/upload.svg') }}" alt="" />
                                                                    <span>{{ __('Attach Image') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action-btns">
                                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                                    <i data-lucide="check"></i> {{ __('Create Ticket') }}
                                                </button>

                                                <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-lucide="x"></i> {{ __('Close') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Modal for open Ticket end-->
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script src="{{ asset('front/js/moment.min.js') }}"></script>
    <script src="{{ asset('front/js/daterangepicker.min.js') }}"></script>
    <script>


        // Initialize datepicker
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        });

        @if(request('daterange') == null)
        // Set default is empty for date range
        $('input[name=daterange]').val('');
        @endif

        // Reset filter
        $('.reset-filter').on('click',function(){
            window.location.href = "{{ route('user.ticket.index') }}";
        });

        let randomNum = 0;

        function addNewAttachment(){

            var el = '<div class="wrap-custom-file"><input type="file" name="attachments[]" id="attachment-'+randomNum+'" accept=".jpeg, .jpg, .png" /> <label for="attachment-'+randomNum+'"><img class="upload-icon" src="{{ asset('front/images/icons/upload.svg') }}" alt="" /> <span>{{ __('Attach Image') }}</span> </label> <div class="close" onclick="removeAttachment(this)"><i data-lucide="x"></i></div></div>';

            $('#attachments').append(el);

            randomNum++;

            lucide.createIcons();

            runImagePreviewer();
        }

        function removeAttachment(el){
            $(el).parent().remove();
        }

    </script>
    @endpush
@endsection
