@extends('frontend::layouts.user')
@section('title')
    {{ __('KYC') }}
@endsection
@section('content')
<div class="row">
    @include('frontend::user.setting.include.__settings_nav')
    
    @if($user->kyc == \App\Enums\KYCStatus::Verified->value)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="identity-alert approved">
            <div class="icon">
                <i data-lucide="check-circle"></i>
            </div>
            <div class="contents">
                <div class="head">{{ __('Verification Center') }}</div>
                <div class="content">
                    {{ __('You have submitted your documents and it is verified') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
        <div class="site-card">
            <div class="site-card-header">
                <div class="title">{{ __('Verification Center') }}</div>
            </div>
            <div class="site-card-body">
                @forelse($kycs as $kyc)
                <a href="{{ route('user.kyc.submission',encrypt($kyc->id)) }}" class="site-btn polis-btn mb-2 me-2"><i data-lucide="file"></i>
                    {{ $kyc->name }}
                </a>
                @empty
                <p class="mb-0">
                    <i>{{ __('You have nothing to submit') }}</i>
                </p>
                @endforelse
            </div>
            <!-- Modal for kycDetails-->
            <div class="modal fade" id="kycDetails" tabindex="-1" aria-labelledby="kycDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content site-table-modal">
                        <div class="modal-body popup-body">
                            <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                            <div class="popup-body-text p-2">
                                <div class="title">{{ __('Details') }}</div>
                                <div class="item-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for kycDetails end-->
        </div>
        <div class="site-card">
            <div class="site-card-header">
                <div class="title">{{ __('KYC History') }}</div>
            </div>
            <div class="site-card-body">
                <div class="row">
                    @foreach($user_kycs as $kyc)
                    <div class="col-md-12 col-xl-12">
                        <div
                        @class([
                            'identity-alert',
                            'pending' => $kyc->status == 'pending',
                            'not-approved' => $kyc->status == 'rejected',
                            'approved' => $kyc->status == 'approved'
                        ])>
                            <div class="contents">
                                <div class="content">
                                    <strong>{{ $kyc->kyc?->name ?? $kyc->type }}</strong> is @if($kyc->status == 'pending')
                                    <div class="type site-badge badge-pending">{{ ucfirst($kyc->status) }}</div>
                                @elseif($kyc->status == 'rejected')
                                    <div class="type site-badge badge-failed ">{{ ucfirst($kyc->status) }}</div>
                                @elseif($kyc->status == 'approved')
                                    <div class="type site-badge badge-success">{{ ucfirst($kyc->status) }}</div>
                                @endif
                                    <a href="javascript:void(0)" class=" ms-2" id="openModal" data-id="{{ $kyc->id }}"> {{ __('View Details') }}</a>
                                    <br>
                                    <small><i>{{ __('Submission Date:') }} {{ $kyc->created_at->format('d M Y h:i A') }}</i></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).on('click','#openModal',function(){
            "use strict";

            let id = $(this).data('id');

            $.get("{{ route('user.kyc.details') }}",{id:id},function(response){
                $('.item-body').html(response.html);
                $('#kycDetails').modal('show');
            });

        });
    </script>
@endsection
