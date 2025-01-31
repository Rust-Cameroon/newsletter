<div
    class="modal fade"
    id="editContent"
    tabindex="-1"
    aria-labelledby="editHowItWorksModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Edit') }}</h3>
                    <form action="{{ route('admin.social.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="updatedId" name="id">
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>
                            <input type="text" name="icon_name" class="box-input mb-0 icon_name" placeholder="Name"
                                   required=""/>
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Icon Class') }} <a class="link"
                                                                                            href="https://fontawesome.com/icons"
                                                                                            target="_blank">{{ __('Fontawesome') }}</a>:</label>
                            <input type="text" name="class_name" class="box-input mb-0 class_name"
                                   placeholder="Icon Class" required=""/>
                        </div>
                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('url:') }}</label>
                            <textarea name="url" class="form-textarea url" placeholder="Url"></textarea>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __(' Save Changes') }}
                            </button>
                            <a
                                href="#"
                                class="site-btn-sm red-btn"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                <i data-lucide="x"></i>
                                {{ __(' Close') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
