<div
    class="modal fade"
    id="editCron"
    tabindex="-1"
    aria-labelledby="editCronModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">

               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Edit Cron Job') }}</h3>
                    <form action="" method="post" id="editCronForm" enctype="multipart/form-data">
                        @csrf

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="name" value="{{ old('name') }}" id="edit-name" class="form-control mb-0" required=""/>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Run Every:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="schedule" value="{{ old('schedule') }}" id="edit-schedule" class="form-control mb-0" required=""/>
                                <span class="input-group-text">{{ __("Seconds") }}</span>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Next Run At:') }}</label>
                            <div class="input-group joint-input">
                                <input type="datetime-local" name="next_run_at" value="{{ old('next_run_at') }}" id="edit-next-run" class="form-control mb-0" required=""/>
                            </div>
                        </div>

                        <div class="site-input-groups" id="url-area">
                            <label for="" class="box-input-label">{{ __('URL:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="url" value="{{ old('url') }}" class="form-control mb-0" id="edit-url" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Status:') }}</label>

                            <div class="input-group joint-input">
                                <select name="status" class="form-select" id="edit-status">
                                    <option value="running" selected>{{ __('Running') }}</option>
                                    <option value="paused">{{ __('Paused') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Update Cron Job') }}
                            </button>
                            <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal" aria-label="Close">
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
