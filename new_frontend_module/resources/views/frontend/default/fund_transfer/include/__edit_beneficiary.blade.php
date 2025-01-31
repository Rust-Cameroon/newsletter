<div class="modal fade" id="editBox" tabindex="-1" aria-labelledby="editBoxModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i data-lucide="x"></i></button>
                <div class="popup-body-text">
                    <div class="title">Edit Beneficiary</div>
                    <form action="{{ route('user.fund_transfer.beneficiary.update') }}" method="POST">
                        @csrf
                        <div class="step-details-form">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label">Select Bank<span
                                                class="required">*</span></label>
                                        <select class="add-beneficiary box-input bank_name" name="bank_id" id="edit_bank_name">
                                            <option selected disabled>Select Bank</option>
                                            <option value="null">Own Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="" class="input-label">Account Number<span
                                                class="required">*</span></label>
                                        <input type="text" id="edit_account_number"
                                               class="box-input" required name="account_number">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="">Name on account<span class="required">*</span></label>
                                        <input type="text" class="box-input"
                                               required name="account_name" id="edit_account_name">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12" id="branch_name_sec">
                                    <div class="inputs">
                                        <label for="" class="input-label">Branch Name<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input"
                                               required name="branch_name" id="edit_branch_name">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="inputs">
                                        <label for="">Nick Name<span
                                                class="required">*</span></label>
                                        <input type="text" class="box-input"
                                               required name="nick_name" id="edit_nick_name">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                Save Changes
                            </button>
                            <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal"
                               aria-label="Close">
                                <i data-lucide="x"></i>
                                Close
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
