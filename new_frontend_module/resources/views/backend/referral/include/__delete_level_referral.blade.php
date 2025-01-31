<div
    class="modal fade"
    id="deleteReferral"
    tabindex="-1"
    aria-labelledby="deleteLevelModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text centered">
                    <div class="info-icon">
                        <i data-lucide="alert-triangle"></i>
                    </div>
                    <div class="title">
                        <h4>{{ __('Are you sure?') }}</h4>
                    </div>
                    <p>
                        {{ __('You want to delete?') }}
                    </p>

                    <div class="action-btns">
                        <form action="" method="post" id="level-delete">
                            @csrf

                            <input type="hidden" name="type" class="level-type">

                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Confirm') }}
                            </button>
                            <a href="" class="site-btn-sm red-btn" type="button" data-bs-dismiss="modal"
                               aria-label="Close"><i data-lucide="x"></i>Cancel</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
