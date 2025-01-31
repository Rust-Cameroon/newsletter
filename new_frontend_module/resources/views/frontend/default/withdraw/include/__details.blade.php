<tr>
    <td><strong>{{ __('Withdraw Fee') }}</strong></td>
    <td><span class="withdrawFee">{{ $charge }}</span> {{ $currency }}</td>
</tr>

@if($conversionRate != null)
    <tr class="conversion">
        <td><strong>{{ __('Conversion Rate') }}</strong></td>
        <td class="conversion-rate"> 1 {{ $currency }} = {{ $conversionRate }}</td>
    </tr>
    <tr class="conversion">
        <td><strong>{{ __('Pay Amount') }}</strong></td>
        <td class="pay-amount"></td>
    </tr>
@endif

<tr>
    <td><strong>{{ __('Withdraw Account') }}</strong></td>
    <td>{{ $name }}</td>
</tr>

@foreach($credentials as $name => $data)
    <tr>
        <td><strong>{{$name}}</strong></td>
        <td>

            @if($data['type'] == 'file')
                <img src="{{ asset( data_get($data,'value')) }}" alt="">
            @else
                {{ data_get($data,'value') }}
            @endif
        </td>
    </tr>
@endforeach

