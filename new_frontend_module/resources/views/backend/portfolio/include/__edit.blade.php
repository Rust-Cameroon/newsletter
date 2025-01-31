<div
    class="modal fade"
    id="editPortfolio"
    tabindex="-1"
    aria-labelledby="editPortfolioModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <form id="portfolioEditForm" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="popup-body-text">
                        <h3 class="title mb-4">{{ __('Edit Portfolio') }}</h3>
                        <div class="site-input-groups">
                            <label class="box-input-label" for="">{{ __('Portfolio Icon:') }}</label>
                            <div class="wrap-custom-file">
                                <input type="file" name="icon" id="image6" accept=".gif, .jpg, .png, .svg"/>
                                <label for="image6" id="image-old">
                                    <img class="upload-icon" src="{{ asset('global/materials/upload.svg') }}" alt=""/>
                                    <span>{{ __('Update Icon') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="site-input-groups row mb-0">
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Level:') }}</label>
                                    <input type="text" name="level" class="box-input mb-0 level" required=""/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Portfolio Name:') }}</label>
                                    <input type="text" name="portfolio_name" class="box-input mb-0 portfolio-name" required=""/>
                                </div>
                            </div>
                        </div>

                        <div class="site-input-groups row mb-0">

                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Minimum Transactions:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control minimum-transactions" name="minimum_transactions" oninput="this.value = validateDouble(this.value)">
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Bonus:') }}</label>
                                    <div class="input-group joint-input">
                                        <input type="text" class="form-control bonus" name="bonus" oninput="this.value = validateDouble(this.value)">
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="site-input-groups mb-0">
                            <label for="" class="box-input-label">{{ __('Description:') }}</label>
                            <textarea name="description" class="form-textarea description"></textarea>
                        </div>
                        <div class="site-input-groups mb-0">
                            <label class="box-input-label" for="">{{ __('Status:') }}</label>
                            <div class="switch-field">
                                <input type="radio" id="activeStatus" name="status" value="1">
                                <label for="activeStatus">{{ __('Active') }}</label>
                                <input type="radio" id="disableStatus" name="status" value="0">
                                <label for="disableStatus">{{ __('Disabled') }}</label>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
