<td><strong>{{ __('Payment Method:') }}</strong></td>
<td>
    <div class="input-group mb-0">
        <select class="site-nice-select" aria-label="Default select example" name="gateway_code" id="gatewaySelect"
                required id="selectWallet">
            @foreach($gateways as $gateway)
                <option value="{{ $gateway->gateway_code }}">{{ $gateway->name}}</option>
            @endforeach
        </select>
    </div>
</td>
