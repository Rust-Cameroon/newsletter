<?php

namespace App\Http\Controllers\Frontend;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Monnify\Monnify;
use Mollie\Laravel\Facades\Mollie;
use Payment\Securionpay\SecurionpayTxn;
use Paystack;
use Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Txn;

class IpnController extends Controller
{
    use Payment;

    public function coinpaymentsIpn(Request $request)
    {
        $input = $request->all();
        $txn = $input['item_name'];
        $status = $input['status'];
        if ($status >= 100 || $status == 2) {
            self::paymentSuccess($txn);
        }
    }

    public function nowpaymentsIpn(Request $request)
    {
        $input = $request->all();
        $txn = $input['order_id'];
        $status = $input['payment_status'];
        if ($status == 'finished') {
            self::paymentSuccess($txn);
        }
    }

    public function cryptomusIpn(Request $request)
    {
        $data = $request->all();
        $gatewayInfo = gateway_info('cryptomus');
        $merchantId = $gatewayInfo->merchant_id;
        $paymentKey = $gatewayInfo->payment_key;
        $payment = \Cryptomus\Api\Client::payment($paymentKey, $merchantId);
        $result = $payment->info($data);
        $txn = $result['order_id'];
        $status = $result['status'];
        if ($status == 'paid') {
            $transaction = Transaction::tnx($txn);
            if ($transaction->type == TxnType::Withdraw) {
                Txn::update($transaction->tnx, TxnStatus::Success, $transaction->user_id);
            } else {
                self::paymentSuccess($txn);
            }

        }
    }

    public function paypalIpn(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $txn = $response['purchase_units'][0]['reference_id'];

            return self::paymentSuccess($txn);

        }

        return redirect()
            ->route('user.deposit.now')
            ->with('error', $response['message'] ?? 'Something went wrong.');

    }

    public function mollieIpn(Request $request)
    {
        $paymentId = $request->id;
        $payment = Mollie::api()->payments()->get($paymentId);
        if ($payment->isPaid()) {
            $ref = $request->reftrn;

            return self::paymentSuccess($ref);
        }
    }

    public function perfectMoneyIpn(Request $request)
    {
        $ref = Crypt::decryptString($request->PAYMENT_ID);

        return self::paymentSuccess($ref);
    }

    public function paystackIpn()
    {
        $paymentDetails = Paystack::getPaymentData();
        if ($paymentDetails['data']['status'] == 'success') {
            $transactionId = $paymentDetails['data']['reference'];

            return self::paymentSuccess($transactionId);

        }

        return redirect()->route('status.cancel');

    }

    public function flutterwaveIpn()
    {
        if (isset($_GET['status'])) {

            $credentials = gateway_info('flutterwave');

            // Check payment status
            $txnid = $_GET['tx_ref'];
            $txnInfo = Transaction::tnx($txnid);

            if ($_GET['status'] == 'cancelled') {
                $txnInfo->update([
                    'status' => TxnStatus::Failed,
                ]);

            } elseif ($_GET['status'] == 'successful') {
                $txid = $_GET['transaction_id'];

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$credentials->secret_key,
                ])->get("https://api.flutterwave.com/v3/transactions/{$txid}/verify");

                if ($response->successful()) {
                    $res = $response->json();
                    $amountPaid = $res['data']['charged_amount'];
                    $amountToPay = $res['data']['meta']['price'];

                    if ($amountPaid >= $amountToPay) {
                        return self::paymentSuccess($txnid, false);
                    }
                    $txnInfo->update([
                        'status' => TxnStatus::Failed,
                    ]);

                } else {
                    $txnInfo->update([
                        'status' => TxnStatus::Failed,
                    ]);
                }
            }
        }
    }

    public function coingateIpn(Request $request)
    {
        if ($request->status == 'paid') {
            self::paymentSuccess($request->order_id);
        } else {
            Txn::update($request->order_id, 'failed');
        }
    }

    public function monnifyIpn()
    {

        (isset($_GET) && isset($_GET['paymentReference'])) ?
            ($ref = htmlspecialchars($_GET['paymentReference'])) : $ref = null;
        $trx = Session::get('deposit_tnx');
        $txnInfo = Transaction::tnx($trx);
        if (htmlspecialchars($_GET['paymentReference'])) {

            //Query the transaction reference from your DB call the method

            $monnify = new Monnify();

            $verify = $monnify->verifyTrans($txnInfo->approval_cause);

            if ($verify['paymentStatus'] == 'PAID') {
                $txnInfo->update([
                    'approval_cause' => 'none',
                ]);

                return self::paymentSuccess($ref, false);

                //Payment has been verified!

            }
            Txn::update($ref, 'failed');

        } else {
            Txn::update($ref, 'failed');
        }
    }

    public function nonHostedSecurionpayIpn(Request $request)
    {
        $depositTnx = Session::get('deposit_tnx');
        $tnxInfo = Transaction::tnx($depositTnx);
        $securionPay = new SecurionpayTxn($tnxInfo);

        return $securionPay->nonHostedPayment($request);
    }

    public function coinremitterIpn(Request $request)
    {
        $txn = $request->description;
        if ($request->status == 'paid') {
            return self::paymentSuccess($txn);
        }
    }

    public function btcpayIpn(Request $request)
    {
        $gatewayInfo = gateway_info('btcpayserver');
        $host = $gatewayInfo->host;
        $apiKey = $gatewayInfo->api_key;
        $storeId = $gatewayInfo->store_id;
        $webhookSecret = $gatewayInfo->webhook_secret;

        $raw_post_data = file_get_contents('php://input');
        $payload = json_decode($raw_post_data, false, 512, JSON_THROW_ON_ERROR);

        // Get the BTCPay signature header.
        $headers = getallheaders();
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'btcpay-sig') {
                $sig = $value;
            }
        }

        $webhookClient = new \BTCPayServer\Client\Webhook($host, $apiKey);

        // Validate the webhook request.
        if (! $webhookClient->isIncomingWebhookRequestValid($raw_post_data, $sig, $webhookSecret)) {
            throw new \RuntimeException(
                'Invalid BTCPayServer payment notification message received - signature did not match.'
            );
        }
        $data = $request->all();
        self::paymentSuccess($data['metadata']['orderId']);
    }

    public function binanceIpn(Request $request)
    {
        header('Content-Type: application/json');
        $webhookResponse = $request->all();
        $returnCode = $webhookResponse['bizStatus'];
        $data = json_decode($webhookResponse['data'], true);
        if ($returnCode == 'SUCCESS') {
            self::paymentSuccess($data['productName']);
        }
    }

    public function blockchainIpn(Request $request)
    {

        $requestData = $request->all();
        $btcValue = $requestData['value'] / 100000000;
        $deposit = Transaction::tnx($requestData['txn']);
        if ($deposit->pay_amount >= $btcValue && $requestData['confirmations'] > 2 && $deposit->status == TxnStatus::Pending) {
            self::paymentSuccess($requestData['txn']);
        }

    }

    public function instamojoIpn(Request $request)
    {
        $payload = $request->all();
        $gatewayInfo = gateway_info('instamojo');
        $instamojoSignature = $payload['mac'];
        $expectedSignature = hash_hmac('sha1', json_encode($payload), $gatewayInfo->salt);
        if ($instamojoSignature == $expectedSignature && $request->payment_status == 'Credit') {
            self::paymentSuccess(($request->txn));
        }

    }

    public function paytmIpn(Request $request)
    {
        $transaction = PaytmWallet::with('receive');
        $txn = $transaction->getOrderId();
        if ($transaction->isSuccessful()) {
            self::paymentSuccess(($txn));
        }
    }

    public function razorpayIpn(Request $request)
    {
        $credentials = gateway_info('razorpay');
        $computedSignature = hash_hmac('sha256', $request->input('razorpay_order_id').'|'.$request->input('razorpay_payment_id'), $credentials->razorpay_secret);
        if ($computedSignature === $request->input('razorpay_signature')) {
            $this->paymentSuccess($request->input('txn'));
        }
    }

    public function twocheckoutIpn(Request $request)
    {

        $gatewayInfo = gateway_info('twocheckout');
        $payload = $request->getContent();
        $expectedHash = hash_hmac('md5', $payload, $gatewayInfo->secret_word);
        $receivedHash = $request->header('X-2Checkout-Signature');
        if ($receivedHash == $expectedHash) {
            $this->paymentSuccess($request->li_0_product_id);
        }
    }
}
