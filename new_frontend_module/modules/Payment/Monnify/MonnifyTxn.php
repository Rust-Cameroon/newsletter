<?php

namespace Payment\Monnify;

use App\Models\Transaction;
use Modules\Payment\Monnify\Monnify;
use Payment\Transaction\BaseTxn;

class MonnifyTxn extends BaseTxn
{
    protected $contractCode;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $this->contractCode = gateway_info('monnify')->contract_code;
    }

    public function deposit()
    {
        $monnifyCredential = gateway_info('monnify');
        $monnify = new Monnify();
        $data = [
            'amount' => $this->amount,
            'customerName' => $this->userName,
            'customerEmail' => $this->userEmail,
            'paymentReference' => $this->txn,
            'paymentDescription' => $this->siteName,
            'currencyCode' => $this->currency,
            'contractCode' => $this->contractCode,
            'redirectUrl' => route('ipn.monnify'),
            'paymentMethods' => [
                'CARD',
                'ACCOUNT_TRANSFER',
            ]];

        //Initialize transaction and redirect to checkout url
        $init = $monnify->initTrans($data);

        Transaction::tnx($this->txn)->update([
            'approval_cause' => $init['transactionReference'],
        ]);

        if ($init['checkoutUrl']) {

            return redirect($init['checkoutUrl']);

        }

        return redirect()->route('status.cancel');

    }
}
