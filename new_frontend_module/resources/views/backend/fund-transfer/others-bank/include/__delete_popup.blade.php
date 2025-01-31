<div
    class="modal"
    id="popUpBox"
    tabindex="-1"
    aria-labelledby="popUpBoxModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-md modal-dialog-centered"
    >
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
                <div class="popup-body-text centered">
                    <div class="info-icon">
                        <i data-lucide="alert-triangle"></i>
                    </div>
                    <div class="title">
                        <h4>{{ __('Are you sure?') }}</h4>
                    </div>
                    <p>
                        {{ __('You want to delete this banks?') }}
                    </p>
                    <div class="action-btns">
                        <a href="{{route('admin.others-bank.destroy',$id)}}" class="site-btn-sm primary-btn me-2" onclick="document.getElementById('dlt-form').submit()">
                            <i data-lucide="check"></i>
                            {{ __('Confirm') }}
                        </a>
                        <button type="button" class="site-btn-sm red-btn" data-bs-dismiss="modal"
                           aria-label="Close">
                            <i data-lucide="x"></i>
                            {{ __('Cancel') }}
                        </button>
                    </div>
                    <form action="{{route('admin.others-bank.destroy',$id)}}" method="post" id="dlt-form">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
