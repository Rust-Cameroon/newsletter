@extends('frontend::layouts.user')
@section('title')
    {{ __('View Ticket') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="site-card">
                        <div class="site-card-header">
                            <div class="title-small">
                                {{ $ticket->title.' - '.$ticket->uuid }}

                                @if($ticket->isOpen())
                                    <span class="ms-2 status site-badge badge-primary">{{ __('Opened') }}</span>
                                @elseif($ticket->isClosed())
                                    <span class="ms-2 status site-badge badge-failed">{{ __('Closed') }}</span>
                                @endif

                            </div>
                            <div class="card-header-links">
                                @if($ticket->isOpen())
                                <a href="" class="card-header-link bg-danger" data-bs-toggle="modal" data-bs-target="#closeTicket">
                                    <i data-lucide="x"></i> {{ __('Close Ticket') }}
                                </a>
                                @else
                                <a href="#" class="card-header-link" data-bs-toggle="modal" data-bs-target="#reopenTicket">
                                    <i data-lucide="check"></i> {{ __('Reopen Ticket') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        @if($ticket->isOpen())
                        <div class="site-card-body">
                            <form action="{{ route('user.ticket.reply') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="uuid" value="{{ $ticket->uuid }}">

                                <div class="step-details-form">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <div class="inputs">
                                                <textarea class="box-textarea" name="message" rows="6" placeholder="Write Reply"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <div class="add-attachment"> <a href="javascript:void(0)" onclick="addNewAttachment()"><i data-lucide="plus-circle"></i>{{ __('Add') }}</a> </div>
                                        </div>

                                        <div class="row" id="attachments">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
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
                                    <div class="buttons">
                                        <button type="submit" class="site-btn primary-btn">
                                            <i data-lucide="message-square"></i>{{ __('Send Reply') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="site-card overflow-hidden">
                        <div class="site-card-body">
                            @foreach($ticket->messages as $message )
                            <div class="support-ticket-single-message @if($message->model == 'admin') admin @else user @endif">
                                <div class="logo">
                                    @if( $message->model != 'admin')
                                        <img src="{{ asset($ticket->user->avatar ?? 'global/materials/user.png' )}}" alt=""
                                                height="40" width="40">
                                    @else
                                        <img src="{{ asset($message->user->avatar ?? 'global/materials/user.png' )}}" alt=""
                                                height="40" width="40">
                                    @endif
                                </div>
                                @if($message->model == 'admin')
                                <div class="salutation"> {{ __('Hi') }} <span class="name">{{ $user->full_name }},</span> </div>
                                @endif
                                <div class="message-body">
                                    <div class="article">
                                        {{ $message->message }}
                                    </div>

                                </div>
                                <div class="message-footer">
                                    {{-- <div class="regards">{{ __('Best Regards,') }}</div> --}}

                                    @if($message->model != 'admin')
                                    <div class="name">{{ $user->full_name }}</div>
                                    <div class="email"><a href="mailto:">{{ $user->email }}</a></div>
                                    @else
                                        <div class="name">{{ $message->user->name }}</div>
                                    @endif
                                </div>
                                @php
                                    $attachments = json_decode($message->attachments);
                                @endphp

                                @if(is_array($attachments) && count($attachments) > 0)
                                <div class="message-attachments">
                                    <div class="title">{{ __('Attachments') }}</div>
                                    <div class="single-attachment">
                                        @foreach ($attachments as $attachment)
                                        <div class="attach">
                                            <a href="{{ asset($attachment) }}" target="_blank">
                                                <i data-lucide="image"></i> {{ substr($attachment,14) }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach

                            <div class="support-ticket-single-message user">
                                <div class="logo">
                                    <img src="{{ asset($ticket->user->avatar ?? 'global/materials/user.png' )}}" alt="" />
                                </div>

                                <div class="message-body">
                                    <div class="article">{{ $ticket->message }}</div>
                                </div>

                                <div class="message-footer">
                                    <div class="name">{{ $user->full_name }}</div>
                                    <div class="email"> <a href="mailto:">{{ $user->email }}</a> </div>
                                </div>

                                @php
                                    $ticket_attachments = $ticket->attachments;
                                @endphp

                                @if(is_array($ticket_attachments) && count($ticket_attachments) > 0)
                                <div class="message-attachments">
                                    <div class="title">{{ __('Attachments') }}</div>
                                    <div class="single-attachment">
                                        @foreach ($ticket_attachments as $attachment)
                                        <div class="attach">
                                            <a href="{{ asset($attachment) }}" target="_blank">
                                                <i data-lucide="image"></i> {{ substr($attachment,14) }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Modal for Close Ticket -->
                            <div class="modal fade" id="closeTicket" tabindex="-1" aria-labelledby="closeTicketModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content site-table-modal">
                                        <div class="modal-body popup-body"> <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> </button>
                                            <div class="popup-body-text centered">
                                                <div class="info-icon"> <i data-lucide="alert-triangle"></i> </div>
                                                <div class="title">
                                                    <h4>{{ __('Are you sure?') }}</h4>
                                                </div>
                                                <p>{{ __('You want to Close this Ticket?') }}</p>
                                                <div class="action-btns"> <a href="{{ route('user.ticket.close.now',$ticket->uuid) }}" class="site-btn-sm primary-btn me-2"> <i data-lucide="check"></i> Confirm </a> <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> Cancel </a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Close Ticket End-->

                            <!-- Modal for Reopen Ticket -->
                            <div class="modal fade" id="reopenTicket" tabindex="-1" aria-labelledby="reopenTicketModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content site-table-modal">
                                        <div class="modal-body popup-body"> <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> </button>
                                            <div class="popup-body-text centered">
                                                <div class="info-icon"> <i data-lucide="alert-triangle"></i> </div>
                                                <div class="title">
                                                    <h4>{{ __('Are you sure?') }}</h4>
                                                </div>
                                                <p>{{ __('You want to reopen this Ticket?') }}</p>
                                                <div class="action-btns"> <a href="{{ route('user.ticket.show',['uuid' => $ticket->uuid,'action' => 'reopen']) }}" class="site-btn-sm primary-btn me-2"> <i data-lucide="check"></i> Confirm </a> <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close"> <i data-lucide="x"></i> Cancel </a> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Reopen Ticket End-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('js')
<script>

    let randomNum = 0;

    function addNewAttachment(){

        var el = '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"><div class="wrap-custom-file"><input type="file" name="attachments[]" id="attachment-'+randomNum+'" accept=".jpeg, .jpg, .png" /> <label for="attachment-'+randomNum+'"><img class="upload-icon" src="{{ asset('front/images/icons/upload.svg') }}" alt="" /> <span>{{ __('Attach Image') }}</span> </label> <div class="close" onclick="removeAttachment(this)"><i data-lucide="x"></i></div></div></div>';

        $('#attachments').append(el);

        randomNum++;

        lucide.createIcons();

        runImagePreviewer();
    }

    function removeAttachment(el){
        $(el).parent().parent().remove();
    }

</script>
@endpush
@endsection
