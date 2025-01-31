<?php

namespace Payment\BlockIo;

use App\Enums\TxnStatus;
use App\Jobs\IpnJob;
use App\Models\User;
use Payment\Transaction\BaseTxn;
use Txn;

class BlockIoTxn extends BaseTxn
{
    protected $merchantId;

    private $apiKey;

    private $pin;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $blockio = gateway_info('blockio');
        $this->apiKey = $blockio->api_key;
        $this->pin = $blockio->pin;
        $this->toAddress = $fieldData['to_address']['value'] ?? '';

    }

    public function deposit()
    {

        $version = 2; // API version
        $block_io = new \BlockIo\Client($this->apiKey, $this->pin, $version);

        $response = $block_io->get_new_address();

        if ($response->status == 'success') {
            $depositAddress = $response->data->address;
            $qrrData = $depositAddress.'?amount='.$this->amount;
            $qrPayment = getQRCode($qrrData);

            $data = [
                'depositAddress' => $depositAddress,
                'qrPayment' => $qrPayment,
                'amount' => $this->amount,
                'tnx' => $this->txn,
                'currency' => $this->currency,
                'gateway' => 'BlockIo',
            ];

            IpnJob::dispatch('blockio', (object) $data);

            return view('gateway.qrcode', compact('data'));
        }
        notify()->warning('Invalid api info', 'warning');

        return redirect()->back();

    }

    public function withdraw()
    {
        $version = 2; // API version
        $block_io = new \BlockIo\Client($this->apiKey, $this->pin, $version);
        $prepare_transaction_response = $block_io->prepare_transaction(['to_address' => $this->toAddress, 'amount' => $this->amount]);
        $create_and_sign_transaction_response = $block_io->create_and_sign_transaction($prepare_transaction_response);
        $submit_transaction_response = $block_io->submit_transaction(['transaction_data' => $create_and_sign_transaction_response]);

        if ($submit_transaction_response->status == 'success') {
            Txn::update($this->txn, TxnStatus::Success, $this->userId);
        } else {
            $user = User::find($this->userId);
            $user->increment('balance', $this->final_amount);
            Txn::update($this->txn, TxnStatus::Failed, $this->userId);
        }

    }
}
