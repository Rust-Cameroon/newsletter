<?php

namespace App\Jobs;

use App\Enums\TxnStatus;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Txn;

class IpnJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $type;

    private mixed $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'blockio') {
            sleep(4);
            $blockioApi = gateway_info('blockio');
            $blockIo = new \BlockIo\Client($blockioApi->api_key, $blockioApi->pin, 2);

            $addressBalance = $blockIo->get_address_balance(['addresses' => $this->data->depositAddress]);
            $transaction = Transaction::tnx($this->data->tnx);
            if ($addressBalance->data->available_balance >= $this->data->amount && $transaction->status == TxnStatus::Pending) {
                Txn::update($this->data->tnx, TxnStatus::Success, $transaction->user_id);
            }

        }
    }
}
