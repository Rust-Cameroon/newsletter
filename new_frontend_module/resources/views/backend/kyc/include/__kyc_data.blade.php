<h3 class="title mb-4">
    {{ __('KYC Details') }}
</h3>


@if(count($waiting_kycs) > 0)
<div class="site-card">
    <div class="site-card-header">
        <h4 class="title-small">{{ __('Waiting For Approval') }}</h4>
    </div>
    <div class="site-card-body">
        <div class="row">
            @foreach($waiting_kycs as $kyc)
            <div class="col-md-6 col-xl-6 col-sm-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h4 class="title-small">{{ $kyc->kyc?->name ?? $kyc->type }}</h4>
                    </div>
                    <div class="site-card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <small><i>{{ __('Submission Date:') }} {{ $kyc->created_at->format('d M Y h:i A') }}</i></small>
                            </li>
                            @foreach ($kyc->data as $key => $value)
                            <li class="list-group-item">
                                <small><i>{{ $key }}:</i>
                                    @if(file_exists(base_path('assets/'.$value))) <br>
                                    <a href="{{ asset($value) }}" target="_blank" data-bs-toggle="tooltip" title="Click here to view document">
                                        <img src="{{ asset($value) }}" alt="" />
                                    </a>
                                    @else
                                    <strong>{{ $value }}</strong>
                                    @endif
                                </small>
                            </li>
                            @endforeach
                        </ul>

                        @if($kyc->status == 'pending')
                        <form action="{{ route('admin.kyc.action.now') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $kyc->id }}">

                            <div class="site-input-groups mt-4">
                                <label for="" class="box-input-label">{{ __('Details Message(Optional)') }}</label>
                                <textarea name="message" class="form-textarea mb-0"></textarea>
                            </div>

                            <div class="action-btns">
                                <button type="submit" name="status" value="approved" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Approve') }}
                                </button>

                                <button type="submit" name="status" value="rejected" class="site-btn-sm red-btn">
                                    <i data-lucide="x"></i>
                                    {{ __('Reject') }}
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if(count($kycs) > 0)
<div class="site-card">
    <div class="site-card-header">
        <h4 class="title-small">{{ __('KYC History') }}</h4>
    </div>
    <div class="site-card-body">
        <div class="row">
            @foreach($kycs as $kyc)
            <div class="col-md-6 col-xl-6 col-sm-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h4 class="title-small">{{ $kyc->kyc?->name ?? $kyc->type }}</h4>
                    </div>
                    <div class="site-card-body">
                        <div class="list-group">
                            <li class="list-group-item">
                                <small><i>{{ __('Submission Date:') }} {{ $kyc->created_at->format('d M Y h:i A') }}</i></small>
                            </li>
                            @foreach ($kyc->data as $key => $value)
                            <li class="list-group-item">
                                <small>
                                    <i>{{ $key }}:</i>
                                    @if(file_exists(base_path('assets/'.$value))) <br>
                                    <a href="{{ asset($value) }}" target="_blank" data-bs-toggle="tooltip" title="Click here to view document">
                                        <img src="{{ asset($value) }}" alt="" />
                                    </a>
                                    @else
                                    <strong>{{ $value }}</strong>
                                    @endif
                                </small>
                            </li>
                            @endforeach

                            @if($kyc->status != 'pending')
                            <li class="list-group-item">
                                <small><i>{{ __('Status:') }}</i></small>
                                @switch($kyc->status)
                                    @case('approved')
                                        <div class="site-badge success d-inline-block">{{ __('Approved') }}</div>
                                        @break
                                    @case('rejected')
                                        <div class="site-badge danger d-inline-block">{{ __('Rejected') }}</div>
                                        @break
                                @endswitch
                            </li>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
