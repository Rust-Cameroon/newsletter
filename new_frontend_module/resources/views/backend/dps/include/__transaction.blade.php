<h3 class="title mb-4">
    {{ __('Transaction Details') }}
</h3>

<div class="row">
    <div class="col-xl-12">
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('SERIAL') }}</th>
                <th>{{ __('INSTALLMENT DATES') }}</th>
                <th>{{ __('GIVEN DATE') }}</th>
                <th>{{ __('DEFERMENT') }}</th>
                <th>{{ __('PAID AMOUNT') }}</th>
                <th>{{ __('CHARGE') }}</th>
                <th>{{ __('FINAL AMOUNT') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ safe($transaction->installment_date) }}</td>
                    <td>{{ safe($transaction->given_date == null ? 'Yet To Pay' : $transaction->given_date) }}</td>
                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->deferment) }}</td>
                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->paid_amount) }}</td>
                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->charge) }}</td>
                    <td>{{ safe($transaction->given_date == null ? 'None' : $transaction->final_amount) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
