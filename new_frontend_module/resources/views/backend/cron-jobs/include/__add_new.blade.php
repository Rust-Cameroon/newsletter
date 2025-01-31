<div
    class="modal fade"
    id="addNewCron"
    tabindex="-1"
    aria-labelledby="addNewCronModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New Cron Job') }}</h3>
                    <form action="{{ route('admin.cron.jobs.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control mb-0" required=""/>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Run Every:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="schedule" value="{{ old('schedule') }}" class="form-control mb-0" required=""/>
                                <span class="input-group-text">{{ __("Seconds") }}</span>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Next Run At:') }}</label>
                            <div class="input-group joint-input">
                                <input type="datetime-local" name="next_run_at" value="{{ old('next_run_at') }}" class="form-control mb-0" required=""/>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('URL:') }}</label>

                            <div class="input-group joint-input">
                                <input type="text" name="url" value="{{ old('url') }}" class="form-control mb-0" required="" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Status:') }}</label>

                            <div class="input-group joint-input">
                                <select name="status" class="form-select">
                                    <option value="running" selected>{{ __('Running') }}</option>
                                    <option value="paused">{{ __('Paused') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add Cron Job') }}
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
