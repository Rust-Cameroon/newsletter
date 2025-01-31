<?php

namespace Payment\Blockchain;

use App\Models\Transaction;
use Exception;
use Http;
use Payment\Transaction\BaseTxn;

class BlockchainTxn extends BaseTxn
{
    private $xpubCode;

    private $apiKey;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $blockchainInfo = gateway_info('blockchain');
        $this->xpubCode = $blockchainInfo->xpub_code;
        $this->apiKey = $blockchainInfo->api_key;
    }

    public function deposit()
    {

        try {
            $tickerData = Http::get('https://blockchain.info/https://blockchain.info/ticker');
            $bitcoinPriceUSD = $tickerData['USD']['last'];
            $amount = $this->amount / $bitcoinPriceUSD;
            $payAmount = round($amount, 8);

            $responseMain = Http::get('https://blockchain.info/v2/receive', [
                'key' => $this->apiKey,
                'callback' => route('ipn.blockchain', ['txn' => $this->txn]),
                'xpub' => $this->xpubCode,
            ]);
            $mainData = $responseMain->json();

            $depositAddress = $mainData['address'];
            $qrrData = $depositAddress.'?amount='.$payAmount;
            $qrPayment = getQRCode($qrrData);

            Transaction::tnx($this->txn)->update([
                'pay_amount' => $payAmount,
            ]);

            $data = [
                'depositAddress' => $depositAddress,
                'qrPayment' => $qrPayment,
                'amount' => $payAmount,
                'tnx' => $this->txn,
                'currency' => $this->currency,
                'gateway' => 'Blockchain',
            ];

            return view('gateway.qrcode', compact('data'));

        } catch (Exception $e) {
            notify()->error('Something went wrong, Please check api', 'api error');

            return redirect()->back();
        }

    }
}
