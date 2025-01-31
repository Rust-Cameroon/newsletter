<form action="{{ route('ipn.razorpay',['txn' => $data['txn']]) }}" method="POST">
    @csrf
    <script src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ $data['key'] }}"
            data-amount="{{ $data['amount'] }}"
            data-buttontext="{{ $data['button_text'] }}"
            data-name="{{ $data['name'] }}"
            data-description="{{ $data['description'] }}"
            data-image="{{ $data['image'] }}"
            data-prefill.name="{{ $data['prefill_name'] }}"
            data-prefill.email="{{ $data['prefill_email'] }}"
            data-theme.color="{{ $data['theme_color'] }}">
    </script>
</form>
<script>
    document.querySelector('.razorpay-payment-button').click();
    let button = document.querySelector('.razorpay-payment-button');
    button.setAttribute('hidden', '');
</script>
