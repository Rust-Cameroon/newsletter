<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\NotifyTrait;
use App\Traits\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Session;
use Txn;

class StatusController extends Controller
{
    use NotifyTrait, Payment;

    public function pending(Request $request)
    {
        $depositTnx = Session::get('deposit_tnx');

        return self::paymentNotify($depositTnx, 'pending');
    }

    public function success(Request $request)
    {
        if (isset($request->reftrn)) {
            $ref = Crypt::decryptString($request->reftrn);

            return self::paymentSuccess($ref);
        }
        $depositTnx = Session::get('deposit_tnx');

        return self::paymentNotify($depositTnx, 'success');

    }

    public function cancel(Request $request)
    {
        $trx = Session::get('deposit_tnx');
        Txn::update($trx, 'failed');

        notify()->warning('Payment Canceled');

        return redirect(route('user.dashboard'))->setStatusCode(200);
    }
}
