<div class="modal fade" id="deleteBox" tabindex="-1" aria-labelledby="deleteBoxModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><i data-lucide="x"></i></button>
                <div class="popup-body-text centered">
                    <div class="info-icon">
                        <i data-lucide="alert-triangle"></i>
                    </div>
                    <div class="title">
                        <h4>Are you sure?</h4>
                    </div>
                    <p>
                        You want to delete this beneficiary?
                    </p>
                    <div class="action-btns">
                        <form action="{{ route('user.fund_transfer.beneficiary.delete') }}" method="POST" id="dltForm">
                            @csrf
                            <input type="hidden" name="id" id="dltId" value="">
                        </form>
                        <a
                            href="#"
                            onclick="event.preventDefault(); localStorage.clear();  $('#dltForm').submit();"
                            class="site-btn-sm primary-btn me-2">
                            <i data-lucide="check"></i>
                            Confirm
                        </a>
                        <a href="" class="site-btn-sm red-btn" data-bs-dismiss="modal"
                           aria-label="Close">
                            <i data-lucide="x"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
