<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalModalLabel" aria-hidden="true">
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
                    <form action="" id="delete-form" method="post">
                        @csrf
                        <p>
                            {{ __('You want to sure delete this?') }}
                        </p>
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2 confirm_btn">
                                <i data-lucide="check"></i>
                                {{ __('Confirm') }}
                            </button>
                            <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i data-lucide="x"></i>
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
