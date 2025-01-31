<div
    class="modal fade"
    id="editReferral"
    tabindex="-1"
    aria-labelledby="addNewLevelModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <form action="" method="post" id="level-form">
                    @csrf
                    <input type="hidden" name="id" class="referral-id">

                    <div class="popup-body-text">
                        <h3 class="title mb-4 edit-for">{{ __('Edit Level') }}</h3>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Bounty:') }}</label>
                            <div class="input-group joint-input">
                                <input type="text" class="form-control bounty" name="bounty" oninput="this.value = validateDouble(this.value)">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>


                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Save Changes') }}
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
