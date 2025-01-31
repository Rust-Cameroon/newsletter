<div class="site-card">
    <div class="site-card-header">
        <h4 class="title-small">{{ $kyc->kyc?->name ?? $kyc->type }}</h4>
    </div>
    <div class="site-card-body p-0">
        <div class="list-group">
            <li class="list-group-item">
                {{ __('Status') }} :
                @if($kyc->status == 'pending')
                    <div class="type site-badge badge-primary">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'rejected')
                    <div class="type site-badge badge-failed">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'approved')
                    <div class="type site-badge badge-success">{{ ucfirst($kyc->status) }}</div>
                @endif
            </li>
            @if($kyc->status != 'pending')
            <div class="list-group-item">{{ __('Message From Admin') }} : <div class="type site-badge badge-primary">{{ $kyc->message }}</div></div>
            @endif
            @foreach ($kyc->data as $key => $value)
            <li class="list-group-item">{{ $key }} :
                @if(file_exists(base_path('assets/'.$value))) <br>
                <a href="{{ asset($value) }}" target="_blank" data-bs-toggle="tooltip" title="Click here to view document">
                    <img src="{{ asset($value) }}" alt="" />
                </a>
                @else
                <strong>{{ $value }}</strong>
                @endif
            </li>
            @endforeach
        </div>
    </div>
</div>
