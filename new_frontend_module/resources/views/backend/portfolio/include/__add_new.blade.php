<div
    class="modal fade"
    id="addNewPortfolio"
    tabindex="-1"
    aria-labelledby="addNewPortfolioModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New Portfolio') }}</h3>
                    <form action="{{ route('admin.portfolio.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="site-input-groups mb-2">
                            <label class="box-input-label" for="">{{ __('Portfolio Icon:') }}</label>
                            <div class="wrap-custom-file">
                                <input type="file" name="icon" id="icon" accept=".gif, .jpg, .png, .svg"/>
                                <label for="icon">
                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                    <span>{{ __('Upload Icon') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="site-input-groups row mb-0">
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Level:') }}</label>
                                    <input type="text" name="level" value="{{ old('level') }}" class="box-input mb-0"
                                           placeholder="Eg: Level 1, Level 2, Level 3..." required=""/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Portfolio Name:') }}</label>
                                    <input type="text" name="portfolio_name" value="{{ old('portfolio_name') }}"
                                           class="box-input mb-0" placeholder="Portfolio Name" required=""/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Minimum Transactions:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control" name="minimum_transactions" oninput="this.value = validateDouble(this.value)">
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Bonus:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control" name="bonus" oninput="this.value = validateDouble(this.value)">
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Description:') }}</label>
                            <textarea name="description" class="form-textarea" placeholder="Description">{{ old('description') }}</textarea>
                        </div>

                        <div class="site-input-groups mb-0">
                            <label class="box-input-label" for="">{{ __('Status:') }}</label>
                            <div class="switch-field">
                                <input type="radio" id="radioRaningStatusActive" name="status" checked="" value="1">
                                <label for="radioRaningStatusActive">{{ __('Active') }}</label>
                                <input type="radio" id="radioRaningStatusDisabled" name="status" value="0">
                                <label for="radioRaningStatusDisabled">{{ __('Disabled') }}</label>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add Portfolio') }}
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
