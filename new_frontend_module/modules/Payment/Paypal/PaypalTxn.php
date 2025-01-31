<?php

namespace Payment\Paypal;

use App\Jobs\WithdrawUpdateJob;
use Payment\Transaction\BaseTxn;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalTxn extends BaseTxn
{
    protected $toEmail;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $fieldData = json_decode($txnInfo->manual_field_data, true);
        $this->toEmail = $fieldData['paypal_email']['value'] ?? '';
    }

    public function withdraw()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $data = [
            'sender_batch_header' => [
                'sender_batch_id' => $this->txn,
                'email_subject' => '',
                'email_message' => '',
            ],
            'items' => [
                0 => [
                    'recipient_type' => 'EMAIL',
                    'amount' => [
                        'value' => $this->amount,
                        'currency' => $this->currency,
                    ],
                    'note' => 'Thanks for your patronage!',
                    'sender_item_id' => $this->txn,
                    'receiver' => $this->toEmail,
                    'alternate_notification_method' => [
                        'phone' => [
                            'country_code' => '91',
                            'national_number' => '9999988888',
                        ],
                    ],
                    'notification_language' => 'fr-FR',
                ],
            ],
        ];
        $response = $provider->createBatchPayout($data);

        $data = [
            'payout_batch_id' => $response['batch_header']['payout_batch_id'],
            'tnx' => $this->txn,
        ];

        WithdrawUpdateJob::dispatch('paypal', (object) $data);

        return $data;
    }

    public function deposit()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('ipn.paypal'),
                'cancel_url' => route('status.cancel'),
            ],
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => $this->currency,
                        'value' => $this->amount,
                    ],
                    'reference_id' => $this->txn,

                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('user.dashboard')
                ->with('error', 'Something went wrong.');

        }

        return redirect()
            ->route('user.dashboard')
            ->with('error', $response['message'] ?? 'Something went wrong.');

    }
}
