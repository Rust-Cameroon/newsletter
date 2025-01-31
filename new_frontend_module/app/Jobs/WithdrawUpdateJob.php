<?php

namespace App\Jobs;

use App\Enums\TxnStatus;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Txn;

class WithdrawUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $type;

    public $data;

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

        if ($this->type == 'paypal') {
            sleep(4);
            $payoutId = $this->data->payout_batch_id;
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->showBatchPayoutDetails($payoutId);

            $transaction = Transaction::tnx($this->data->tnx);

            if ($response['batch_header']['batch_status'] == 'SUCCESS') {
                Txn::update($this->data->tnx, TxnStatus::Success, $transaction->user_id);
            } else {

                $user = User::find($transaction->user_id);
                $user->increment('balance', $transaction->final_amount);
                Txn::update($transaction->tnx, TxnStatus::Failed, $transaction->user_id);
            }

        }

    }
}
