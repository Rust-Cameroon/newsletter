<div class="modal fade"
     id="staffModal"
     tabindex="-1"
     aria-labelledby="addNewScheduleModalLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <form action="{{ route('admin.staff.store') }}" method="post" id="modalForm">
                    @csrf
                    <div class="popup-body-text">
                        <h3 class="title mb-4" id="modalTitle">{{ __('Add New Staff') }}</h3>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Name:') }}</label>
                            <input
                                type="text"
                                name="name"
                                class="box-input mb-0"
                                placeholder="Staff Name"
                                required
                            />
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Email:') }}</label>
                            <input
                                type="email"
                                name="email"
                                class="box-input mb-0"
                                placeholder="Staff Email"
                                required
                            />
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Password:') }}</label>
                            <input
                                type="password"
                                name="password"
                                class="box-input mb-0"
                                placeholder="Password"
                                required
                            />
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Confirm Password:') }}</label>
                            <input
                                type="password"
                                name="confirm-password"
                                class="box-input mb-0"
                                placeholder="Confirm Password"
                                required
                            />
                        </div>

                        <div class="site-input-groups">
                            <label class="box-input-label" for="">{{ __('Select Role:') }}</label>
                            <select name="role" class="form-select">
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{ str_replace('-', ' ', $role->name) }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add Staff') }}
                            </button>
                            <a
                                href="#"
                                class="site-btn-sm red-btn"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-lucide="x"></i>
                                {{ __('Close') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
