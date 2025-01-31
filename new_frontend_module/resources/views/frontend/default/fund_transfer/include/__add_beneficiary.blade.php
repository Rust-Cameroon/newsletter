<div class="modal fade" id="addBox" tabindex="-1" aria-labelledby="addBoxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        data-lucide="x"></i></button>
                <div class="popup-body-text">
                    <div class="title">{{ __('Add New Beneficiary') }}</div>
                    <form action="{{ route('user.fund_transfer.beneficiary.store') }}" method="POST">
                        @csrf
                        <div class="step-details-form">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label d-block">{{ __('Select Bank') }}<span
                                                class="required">*</span></label>
                                        <select class="add-beneficiary box-input" name="bank_id" id="bank_name">
                                            <option selected disabled>{{ __('Select Bank') }}</option>
                                            <option value="null">{{ __('Own Bank') }}</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Account Number') }}<span class="required">*</span></label>
                                        <input type="text" class="box-input" required name="account_number">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="">{{ __('Name on account') }}<span class="required">*</span></label>
                                        <input type="text" class="box-input" required name="account_name">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12" id="branch_name_sec">
                                    <div class="inputs">
                                        <label for="" class="input-label">{{ __('Branch Name') }}<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input" name="branch_name">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12" id="nick_name">
                                    <div class="inputs">
                                        <label for="">{{ __('Nick Name') }}<span class="required">*</span></label>
                                        <input type="text" class="box-input" required name="nick_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add New') }}
                            </button>
                            <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
