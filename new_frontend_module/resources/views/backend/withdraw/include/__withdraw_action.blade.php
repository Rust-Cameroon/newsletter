<h3 class="title mb-4">
    {{ __('Withdraw Approval Action') }}
</h3>

<ul class="list-group mb-4">
    <li class="list-group-item">
        {{ __('Withdraw Amount') }}: <strong>{{ $data->amount .' '. $currency }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('Payable Amount') }}: <strong>{{ $data->pay_currency.' '.$data->pay_amount   }}</strong>
    </li>
    <li class="list-group-item">
        {{ __('Charge') }}: <strong>{{ $currencySymbol.' '.$data->charge }}</strong>
    </li>
</ul>

<ul class="list-group mb-4">

    @foreach( json_decode($data->manual_field_data,true) as $name => $data)
        <li class="list-group-item">
            {{ $name }}: @if( $data['type'] == 'file' )
                <img src="{{ asset($data['value']) }}" alt=""/>
            @else
                <strong>{{ $data['value'] }}</strong>
            @endif
        </li>
    @endforeach
</ul>

<form action="{{ route('admin.withdraw.action.now') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">

    <div class="site-input-groups">
        <label for="" class="box-input-label">{{ __('Details Message(Optional)') }}</label>
        <textarea name="message" class="form-textarea mb-0" placeholder="Details Message"></textarea>
    </div>

    <div class="action-btns">
        <button type="submit" name="approve" value="yes" class="site-btn-sm primary-btn me-2">
            <i data-lucide="check"></i>
            {{ __('Approve') }}
        </button>
        <button type="submit" name="reject" value="yes" class="site-btn-sm red-btn">
            <i data-lucide="x"></i>
            {{ __('Reject') }}
        </button>
    </div>

</form>

<script>
    'use strict';
    lucide.createIcons();
</script>



