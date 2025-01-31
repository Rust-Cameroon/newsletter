<h3 class="title mb-4">{{ __('Edit Staff') }}</h3>
<form action="{{ route('admin.staff.update',$staff->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Name:') }}</label>
        <input
            type="text"
            name="name"
            class="box-input mb-0"
            value="{{ $staff->name }}"
            required=""
            id="name"
        />
    </div>
    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Email:') }}</label>
        <input
            type="email"
            name="email"
            class="box-input mb-0"
            value="{{ $staff->email }}"
            required=""
            id="email"
        />
    </div>
    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Password:') }}</label>
        <input
            type="password"
            name="password"
            class="box-input mb-0"
        />
    </div>
    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Confirm Password:') }}</label>
        <input
            type="password"
            name="confirm-password"
            class="box-input mb-0"
        />
    </div>

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Status:') }}</label>
        <div class="switch-field">
            <input type="radio" id="radio-seven" name="status" value="1" @checked($staff->status)>
            <label for="radio-seven">{{ __('Active') }}</label>
            <input type="radio" id="radio-eight" name="status" value="0" @checked(!$staff->status)>
            <label for="radio-eight">{{ __('Disabled') }}</label>
        </div>
    </div>


    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Select Role:') }}</label>
        <select name="role" class="form-select" id="role">
            @foreach($roles as $role)
                <option
                    @selected($role->name == $staff->roles[0]['name']) value="{{$role->name}}">{{ str_replace('-', ' ', $role->name) }}</option>
            @endforeach

        </select>
    </div>

    <div class="action-btns">
        <button type="submit" href="" class="site-btn-sm primary-btn me-2">
            <i data-lucide="check"></i>
            {{ __('Save Changes') }}
        </button>
        <a
            href="#"
            class="site-btn-sm red-btn"
            data-bs-dismiss="modal"
            aria-label="Close"
        >
            <i data-lucide="x"></i>
            Close
        </a>
    </div>
</form>
