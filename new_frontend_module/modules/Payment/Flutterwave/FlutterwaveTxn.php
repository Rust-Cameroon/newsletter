<?php

namespace Payment\Flutterwave;

use App\Enums\TxnStatus;
use Illuminate\Support\Facades\Http;
use Payment\Transaction\BaseTxn;
use Txn;

class FlutterwaveTxn extends BaseTxn
{
    private $secretKey;

    /**
     * @var mixed|string
     */
    private mixed $accountBank;

    /**
     * @var mixed|string
     */
    private mixed $accountNumber;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $gatewayInfo = gateway_info('flutterwave');
        $this->secretKey = $gatewayInfo->secret_key;

        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->accountBank = $fieldData['account_bank']['value'] ?? '';
        $this->accountNumber = $fieldData['account_number']['value'] ?? '';
    }

    public function deposit()
    {
        $info = [
            'tx_ref' => $this->txn,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_options' => 'card',
            'redirect_url' => route('ipn.flutterwave'),
            'customer' => [
                'email' => $this->userEmail,
                'name' => $this->userName,
            ],
            'meta' => [
                'price' => $this->amount,
            ],
            'customizations' => [
                'title' => $this->siteName,
                'description' => '',
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/payments', $info);

        $res = $response->json();

        if ($res['status'] == 'success') {
            $link = $res['data']['link'];

            return redirect($link);
        }

        return redirect()->route('status.cancel');

    }

    public function withdraw()
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->secretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/transfers', [
            'account_bank' => $this->accountBank,
            'account_number' => $this->accountNumber,
            'amount' => $this->amount,
            'narration' => 'Payment for things',
            'currency' => $this->currency,
            'reference' => $this->txn,
            'callback_url' => '',
            'debit_currency' => $this->currency,
        ]);

        $res = $response->json();
        if ($res['status'] == 'success') {
            Txn::update($this->txn, TxnStatus::Success, $this->userId);
        }
    }
}
