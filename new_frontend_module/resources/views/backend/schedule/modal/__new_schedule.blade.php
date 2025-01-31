<div
    class="modal fade"
    id="addNewSchedule"
    tabindex="-1"
    aria-labelledby="addNewScheduleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New Schedule') }}</h3>
                    <form action="{{route('admin.schedule.store')}}" method="post">
                        @csrf
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Schedule Name:') }}</label>
                            <input
                                type="text"
                                name="name"
                                class="box-input mb-0"
                                placeholder="Ex: Hours, Day, Month"
                                required=""
                            />
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Schedule In Hours:') }}</label
                            >
                            <div class="input-group joint-input">
                                <input
                                    type="text"
                                    name="time"
                                    class="form-control"
                                    placeholder="Ex: 24"
                                    onkeypress="return validateNumber(event)"
                                />
                                <span class="input-group-text">{{ __('Hour') }}</span>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add Schedule') }}
                            </button>
                            <a
                                href="#"
                                class="site-btn-sm red-btn"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
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
