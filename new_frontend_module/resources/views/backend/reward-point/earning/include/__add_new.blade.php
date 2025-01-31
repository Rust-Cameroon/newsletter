<div
    class="modal fade"
    id="addNewEarning"
    tabindex="-1"
    aria-labelledby="addNewEarningModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content site-table-modal">
            <div class="modal-body popup-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>

                <div class="popup-body-text">
                    <h3 class="title mb-4">{{ __('Add New Reward Earning') }}</h3>
                    <form action="{{ route('admin.reward.point.earnings.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="site-input-groups mb-2">
                            <label class="box-input-label" for="">{{ __('Portfolio:') }}</label>
                            <div class="input-group mb-0">
                                <select name="portfolio_id" id="portfolio_id" required>\
                                    <option value="" selected disabled>{{ __('Select Portfolio') }}</option>
                                    @foreach($portfolios as $portfolio)
                                        <option value="{{ $portfolio->id }}">{{ $portfolio->portfolio_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="site-input-groups row mb-0">
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Amount Of Transactions:') }}</label>

                                    <div class="input-group joint-input">
                                        <input type="text" name="amount_of_transactions" value="{{ old('amount_of_transactions') }}" class="form-control mb-0" required=""/>
                                        <span class="input-group-text">{{ setting('site_currency','global') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="site-input-groups">
                                    <label for="" class="box-input-label">{{ __('Reward Point:') }}</label>
                                    <input type="text" name="point" value="{{ old('point') }}"
                                           class="box-input mb-0" required=""/>
                                </div>
                            </div>
                        </div>

                        <div class="action-btns">
                            <button type="submit" class="site-btn-sm primary-btn me-2">
                                <i data-lucide="check"></i>
                                {{ __('Add Reward') }}
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
