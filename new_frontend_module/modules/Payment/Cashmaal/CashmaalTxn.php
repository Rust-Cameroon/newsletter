<?php

namespace Payment\Cashmaal;

use App\Enums\TxnStatus;
use Payment\Transaction\BaseTxn;
use Txn;

class CashmaalTxn extends BaseTxn
{
    private $webId;

    /**
     * @var mixed|string
     */
    private mixed $toEmail;

    private $secretKey;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);

        $gatewayInfo = gateway_info('cashmaal');
        $this->webId = $gatewayInfo->web_id;
        $this->secretKey = $gatewayInfo->secret_key;

        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toEmail = $fieldData['to_email']['value'] ?? '';
    }

    public function deposit()
    {

        // Define the Cash-Maal API URL
        $cashMaalApiUrl = 'https://www.cashmaal.com/Pay/';

        // Prepare the form data for Cash-Maal API
        $data = [
            'pay_method' => ' ', // Add your payment method here
            'amount' => $this->amount,
            'currency' => $this->currency,
            'succes_url' => route('status.success'),
            'cancel_url' => route('status.cancel'),
            'client_email' => $this->userEmail,
            'web_id' => $this->webId,
            'order_id' => $this->txn, // You can generate a unique order ID here
            'addi_info' => 'Deposit',
        ];

        $action = [
            'method' => 'POST',
            'url' => $cashMaalApiUrl,
        ];

        return view('gateway.auto_submit', compact('data', 'action'));

    }

    public function withdraw()
    {

        function CashMaal_API($CashMaal_payout_API, $cmd, $req = [])
        {
            $req['cmd'] = $cmd;
            $req['p_secretkey'] = $CashMaal_payout_API;
            $req['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $post_data = http_build_query($req, '', '&');
            static $ch = null;
            if ($ch === null) {
                $ch = curl_init('https://www.cashmaal.com/Pay/'.$cmd.'.php');
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            return $data = curl_exec($ch);

        }

        $CashMaal_API = CashMaal_API($this->secretKey, 'payout_v2', $req = ['to_email' => $this->toEmail, 'currency_is' => $this->currency, 'sending_amount' => $this->amount, 'order_id' => $this->txn, 'addi_info' => 'this is  payment']);
        $CashMaal_API_Json = json_decode($CashMaal_API, true);
        if ($CashMaal_API_Json['status'] == 1) { // its mean Payment Sent Successfully

            Txn::update($this->txn, TxnStatus::Success, $this->userId);

        } else {
            Txn::update($this->txn, TxnStatus::Failed, $this->userId);
        }
    }
}
