<div class="modal fade"
     id="addNewReferral"
     tabindex="-1"
     aria-labelledby="addNewLevelModalLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <form method="post" action="{{ route('admin.referral.store') }}">
                    @csrf
                    <div class="popup-body-text">
                        <input type="hidden" name="type" class="referral-type">
                        <h3 class="title mb-4">{{ __('Add New') }}</h3>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Choose Type:') }}</label>
                            <select name="level_type" class="form-select mb-0" id="" required>
                                <option value="">--{{ __('Select One') }}--</option>
                                @foreach( $referralType as $key => $type)
                                    <option value="{{ $type->value }}"> {{ ucwords(str_replace('_',' ',$type->value)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Bounty:') }}</label>
                            <div class="input-group joint-input">
                                <input type="text" class="form-control" name="bounty" oninput="this.value = validateDouble(this.value)">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>


                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add New') }}
                            </button>
                            <a
                                href="#"
                                class="site-btn-sm red-btn"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
