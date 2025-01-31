<div class="modal fade" id="editNav" tabindex="-1" aria-labelledby="editNavModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="popup-body-text">
                    <form action="{{ route('admin.user.navigation.update') }}" method="POST" id="edit-form">
                        @csrf
                        <input type="hidden" name="type">
                        <h3 class="title mb-4">{{ __('Update Navigation') }}</h3>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Menu Name:') }}</label>
                            <input type="text" name="name" class="box-input mb-0 name" placeholder="Menu Name" required/>
                        </div>
                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Update') }}
                            </button>
                            <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal">
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
