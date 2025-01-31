<?php

namespace Payment\Perfectmoney;

use App\Enums\TxnStatus;
use App\Models\User;
use charlesassets\LaravelPerfectMoney\PerfectMoney;
use Payment\Transaction\BaseTxn;
use Txn;

class PerfectmoneyTxn extends BaseTxn
{
    /**
     * @var mixed|string
     */
    private mixed $sendTo;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $this->sendTo = $fieldData['payment_id']['value'] ?? '';
    }

    public function deposit()
    {
        $paymentUrl = route('ipn.perfectMoney');
        $noPaymentUrl = route('status.cancel');

        return PerfectMoney::render(['PAYMENT_AMOUNT' => $this->amount, 'PAYMENT_ID' => $this->txn, 'PAYMENT_URL' => $paymentUrl, 'PAYMENT_UNITS' => $this->currency, 'NOPAYMENT_URL' => $noPaymentUrl, 'NOPAYMENT_URL_METHOD' => 'GET']);
    }

    public function withdraw()
    {

        $pm = new PerfectMoney;
        $sendMoney = $pm->getBalance($this->amount, $this->sendTo);

        if ($sendMoney['status'] == 'success') {
            Txn::update($this->txn, TxnStatus::Success, $this->userId);
        }

        if ($sendMoney['status'] == 'error') {
            $user = User::find($this->userId);
            $user->increment('balance', $this->final_amount);
            Txn::update($this->txn, TxnStatus::Failed, $this->userId);
        }

        return true;
    }
}
