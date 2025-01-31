<h3 class="title mb-4">{{ __('Service Limit & Charges') }}</h3>
<form action="{{ route('admin.bill.service.update',$service->id) }}" method="post">
    @csrf

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Min Amount:') }}</label>
        <input type="number" class="box-input" name="min_amount" value="{{ $service->min_amount }}"/>
    </div>

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Max Amount:') }}</label>
        <input type="number" class="box-input" name="max_amount" value="{{ $service->max_amount }}"/>
    </div>

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Charge:') }}</label>
        <input type="number" class="box-input" name="charge" placeholder="Charge"  value="{{ $service->charge }}"/>
    </div>

    <div class="site-input-groups">
        <label class="box-input-label" for="">{{ __('Status:') }}</label>
        <div class="switch-field">
            <input type="radio" id="radio-seven" name="status" value="1" @checked($service->status)>
            <label for="radio-seven">{{ __('Active') }}</label>
            <input type="radio" id="radio-eight" name="status" value="0" @checked(!$service->status)>
            <label for="radio-eight">{{ __('Inactive') }}</label>
        </div>
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
            {{ __('Close') }}
        </a>
    </div>
</form>
