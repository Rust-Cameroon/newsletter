@extends('frontend::layouts.user')
@section('content')
    <!-- Modal -->
    <div class="modal fade deposit-modal" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('Deposit With') }} {{ $data['gateway'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-lucide="x"></i></button>
                </div>
                <div class="modal-body">
                    <div class="deposit-qr text-center">
                        <img class="qr-code" src="{{ $data['qrPayment'] }}" alt="">
                    </div>
                    <div class="hex-address">
                        <input type="text" value="{{ $data['depositAddress'] }}" id="depositAddress">
                        <button type="submit" onclick="copyRef('depositAddress')">
                            <i class="anticon anticon-copy"></i>
                            <span id="copy" hidden>{{ __('Copy') }}</span>
                            <input id="copied" hidden value="{{ __('Copied') }}">
                        </button>

                    </div>
                    <p class="mb-0">You can send {{ $data['amount'] . ' ' . $data['currency'] }} to the above address</p>
                    <p class="mb-0"><i class="anticon anticon-bank"></i>{{ __('Pay Amount:') . ' '. $data['amount'] . ' ' . $data['currency'] }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function(){
            "use strict";
            var qrModal = new bootstrap.Modal($('#staticBackdrop2')[0]);
            qrModal.show();
            $('.btn-close').click(function(){
                window.location.href = '{{ route('user.deposit.amount') }}'
            })

        });
    </script>
@endsection



