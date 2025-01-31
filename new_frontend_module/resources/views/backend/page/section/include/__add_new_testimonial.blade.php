<div
    class="modal fade"
    id="addNew"
    tabindex="-1"
    aria-labelledby="addNewTestimonialModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New') }}</h3>
                    <form action="{{ route('admin.page.testimonial.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="site-input-groups row">
                            <label for="" class="box-input-label">{{ __('Picture') }}</label>
                            <div class="wrap-custom-file">
                                <input type="file" name="picture" id="picture" accept=".gif, .jpg, .png"/>
                                <label for="picture">
                                    <img class="upload-icon"
                                         src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                    <span>{{ __('Upload') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>
                            <input type="text" name="name" class="box-input mb-0" placeholder="Name" required=""/>
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Designation:') }}</label>
                            <input type="text" name="designation" class="box-input mb-0" placeholder="Designation" required=""/>
                        </div>
                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Feedback:') }}</label>
                            <textarea name="message" class="form-textarea" placeholder="Feedback"></textarea>
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
