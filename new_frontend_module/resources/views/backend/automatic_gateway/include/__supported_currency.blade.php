@foreach(json_decode($supportedCurrencies) as $currency)
    <option
        value="{{$currency}}"> {{$currency}}
    </option>
@endforeach
