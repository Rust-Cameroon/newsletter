<div
    class="modal fade"
    id="sendEmail"
    tabindex="-1"
    aria-labelledby="sendEmailModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text">
                    <h3 class="title mb-4"> {{ __('Send Mail to') }} <span id="name">{{ $name ?? ''}}</span></h3>
                    <form action="{{route('admin.user.mail-send')}}" method="post" id="send-mail-form">
                        @csrf

                        <input type="hidden" name="id" value="{{ $id ?? 0}}" id="userId">

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Subject:') }}</label>
                            <input
                                type="text"
                                name="subject"
                                class="box-input mb-0"
                                required=""
                            />
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Email Details') }}</label>
                            <textarea name="message" class="form-textarea mb-0"></textarea>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="send"></i>
                                {{ __('Send Email') }}
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
