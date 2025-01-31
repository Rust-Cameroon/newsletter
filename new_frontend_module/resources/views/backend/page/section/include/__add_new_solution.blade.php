<div
    class="modal fade"
    id="addNew"
    tabindex="-1"
    aria-labelledby="addNewSolutionModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New') }}</h3>
                    <form action="{{ route('admin.page.content-store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="bankingsolution">

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Icon Name') }} <a class="link"href="https://lucide.dev/icons/" target="_blank">{{ __('Lucide Icons') }}</a>:</label>
                            <input type="text" name="icon" class="box-input mb-0" placeholder="Icon Name" required=""/>
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Title:') }}</label>
                            <input type="text" name="title" class="box-input mb-0" placeholder="Register" required=""/>
                        </div>
                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Description:') }}</label>
                            <textarea name="description" class="form-textarea" placeholder="Description"></textarea>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Image') }}</label>
                            <div class="wrap-custom-file">
                                <input type="file" name="photo" id="photo" accept=".gif, .jpg, .png"/>
                                <label for="photo">
                                    <img class="upload-icon"
                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                    <span>{{ __('Upload') }}</span>
                                </label>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
