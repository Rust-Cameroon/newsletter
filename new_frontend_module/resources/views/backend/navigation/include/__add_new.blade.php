<div class="modal fade" id="addNewNavMenu" tabindex="-1" aria-labelledby="addNewNavMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <form action="{{ route('admin.navigation.menu.add') }}" method="post">
                    @csrf
                    <div class="popup-body-text">
                        <h3 class="title mb-4">{{ __('Add New Menu Item') }}</h3>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Menu Name:') }}</label>
                            <input type="text" name="name" class="box-input mb-0" placeholder="Menu Name" required=""/>
                        </div>
                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Page:') }}</label>
                            <select name="select_page" class="form-select" id="page-select">
                                <option value="">--{{ __('Select One') }}--</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                                <option value="custom">{{ __('Custom Url') }}</option>

                            </select>
                        </div>
                        <div class="site-input-groups custom-url-input d-none">
                            <label for="" class="box-input-label">{{ __('Custom URL:') }}</label>
                            <input type="text" name="custom_url" class="box-input mb-0" placeholder="Custom URL"/>
                        </div>

                        <div class="site-input-groups">
                            <label for="" class="box-input-label">{{ __('Display In:') }}</label>
                            <select name="type" class="form-select" id="">
                                <option value="header">{{ __('Header') }}</option>
                                <option value="footer">{{ __('Footer') }}</option>
                                <option value="both">{{ __('Header and Footer Both') }}</option>
                            </select>
                        </div>

                        <div class="site-input-groups">
                            <label class="box-input-label" for="">{{ __('Status:') }}</label>
                            <div class="switch-field">
                                <input type="radio" id="active" name="status" checked="" value="1">
                                <label for="active">{{ __('Active') }}</label>
                                <input type="radio" id="disabled" name="status" value="0">
                                <label for="disabled">{{ __('Disabled') }}</label>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add New Menu') }}
                            </button>
                            <a href="#" class="site-btn-sm red-btn" data-bs-dismiss="modal">
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
