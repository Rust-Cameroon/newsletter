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
                            <label for="" class="box-input-label">{{ __('Choose One:') }}</label>
                            <select name="referral_target_id" class="form-select mb-0" id="" required>
                                <option value="">--{{ __('Select One') }}--</option>
                                @foreach( $targets as $target)
                                    <option value="{{ $target->id }}">{{ $target->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Target Amount:') }}</label>
                            <div class="input-group joint-input">
                                <input type="text" class="form-control" name="target_amount" oninput="this.value = validateDouble(this.value)">
                                <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Bounty:') }}</label>
                            <div class="input-group joint-input">
                                <input type="text" class="form-control" name="bounty" oninput="this.value = validateDouble(this.value)">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Description:') }}</label>
                            <textarea name="description" class="form-textarea" placeholder="Description"></textarea>
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
