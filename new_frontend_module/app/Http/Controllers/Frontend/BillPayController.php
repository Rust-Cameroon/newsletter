<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BillStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillService;
use App\Traits\NotifyTrait;
use Bill\Bloc;
use Bill\Flutterwave;
use Bill\Reloadly;
use Bill\Tpaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Txn;

class BillPayController extends Controller
{
    use NotifyTrait;

    public function airtime()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.airtime', compact('countries'));
    }

    public function electricity()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.electricity', compact('countries'));
    }

    public function internet()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.internet', compact('countries'));
    }

    public function cables()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.cables', compact('countries'));
    }

    public function dataBundle()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.data-bundle', compact('countries'));
    }

    public function toll()
    {
        $countries = BillService::where('status', true)->pluck('country')->unique();

        return view('frontend::pay_bill.toll', compact('countries'));
    }

    public function history()
    {
        $bills = Bill::with('service')->latest()->paginate();

        return view('frontend::pay_bill.history', compact('bills'));
    }

    public function store(Request $request)
    {
        if (! setting('kyc_pay_bill') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:bill_services,id',
            'amount' => 'required|integer',
        ]);

        if ($validator->fails()) {

            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        $service = BillService::find($request->service_id);
        $charge = $service->charge_type == 'fixed' ? $service->charge : ($request->amount / 100) * $service->charge;
        $rates = json_decode(plugin_active(ucfirst($service->method))->data, true)['currencies'];
        $rate = data_get($rates, $service->currency);
        $amount = ($request->amount / $rate) + $charge;

        if (auth()->user()->balance < $amount) {
            notify()->error(__('Insufficient Balance!'), 'Error');

            return back();
        }

        $response = match ($service->method) {
            'flutterwave' => (new Flutterwave)->payBill([
                'country' => $service->country_code,
                'customer' => array_values($request->data)[0],
                'amount' => $request->amount,
                'reference' => Str::random(10),
                'type' => $service->name,
            ]),
            'bloc' => (new Bloc)->payBill($service),
            'reloadly' => (new Reloadly)->payBill($service),
            'tpaga' => (new Tpaga)->payBill($service)
        };

        if ($response['status'] == 'success') {

            $bill = Bill::create([
                'bill_service_id' => $request->get('service_id'),
                'user_id' => auth()->id(),
                'data' => $request->get('data'),
                'amount' => $amount,
                'charge' => $charge,
                'status' => BillStatus::Completed,
            ]);

            auth()->user()->decrement('balance', $amount);

            Txn::new($amount, $charge, $amount + $charge, 'System', 'Pay Bill "'.$service->name.'"', TxnType::PayBill, TxnStatus::Success, '', null, $bill->user_id, null, 'User');

            $shortcodes = [
                '[[user_name]]' => auth()->user()->full_name,
                '[[service_name]]' => $service->name,
                '[[amount]]' => $amount,
                '[[charge]]' => $charge,
            ];

            $this->pushNotify('bill_pay', $shortcodes, route('admin.bill.history.complete'), auth()->id(), 'Admin');

            notify()->success($response['message'], 'Success');

            return back();

        }

        notify()->error($response['message'], 'Error');

        return back();

        notify()->success(__('Bill submitted successfully'), 'Success');

        return back();
    }

    public function getServices($country, $type)
    {
        $services = BillService::where('country', $country)->where('type', $type)->get();

        $html = "<option value='' selected disabled>".__('Select Service').'</option>';

        foreach ($services as $service) {
            $html .= sprintf('<option value="%s" data-currency="%s" data-label="%s" data-amount="%s">%s</option>', $service->id, $service->currency, $service->label, $service->amount, $service->name);
        }

        return response()->json([
            'html' => $html,
        ]);
    }

    public function getPaymentDetails(Request $request)
    {
        $service = BillService::findOrFail($request->service_id);
        $charge = $service->charge_type == 'fixed' ? $service->charge : ($request->amount / 100) * $service->charge;

        $currency = setting('site_currency', 'global');
        $currency_rates = json_decode(plugin_active(ucfirst($service->method))->data, true)['currencies'];

        $rate = data_get($currency_rates, $service->currency);
        $payable_amount = ($request->amount / $rate) + $charge;

        return response()->json([
            'charge' => $charge.' '.$currency,
            'amount' => $request->amount.' '.$service->currency,
            'rate' => "1 {$currency} = {$rate} {$service->currency}",
            'payable_amount' => $payable_amount.' '.$currency,
        ]);
    }
}
