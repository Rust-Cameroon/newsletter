@push('js')
<script>
    "use strict";

    $('select[name=country]').select2();

    $('select[name=country]').on('change',function(){

        let country = $(this).val();

        let url = "{{ url('user/pay-bill/get-services') }}/"+country+"/{{ request()->segment(3) }}";

        $.get(url,function(response){
            $('#services').html(response.html);
            $('#services').select2();
        });

    });

    $('#currency').hide();

    $('#services').on('change',function(){
        let minAmount = $('#services option:selected').data('min-amount');
        let maxAmount = $('#services option:selected').data('max-amount');
        let currency = $('#services option:selected').data('currency');
        let amount = $('#services option:selected').data('amount');
        let label = $('#services option:selected').data('label');

        $('#currency').show();
        $('#currency').text(currency);

        if(amount !== 0){
            $('#amount').val(amount);
            $('#amount').attr('readonly',true);
        }else{
            $('#amount').val('');
            $('#amount').attr('readonly',false);
        }

        $('.label-name').text(label);
        $('#label-input').attr('placeholder',label);
        $('#label-input').attr('name','data['+label+']');
        getPaymentDetails();

    });

    $('input[name=amount]').on('keyup',function(){
        getPaymentDetails();
    })

    function getPaymentDetails(){
        let service_id = $('#services option:selected').val();
        let amount = $('input[name=amount]').val();
        let button = $('button[type=submit]');
        let amountField = $('input[name=amount]');

        $.get("{{ route('user.pay.bill.get.payment.details') }}",{amount:amount,service_id},function(response){
            $('.pay-amount').text(response.payable_amount);
            $('.charge').text(response.charge);
            $('.amount').text(response.amount);
            $('.conversion-rate').text(response.rate);
        });
    }

</script>
@endpush
