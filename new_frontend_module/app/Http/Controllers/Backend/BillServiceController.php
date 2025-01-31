<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BillService;
use App\Models\Plugin;
use Bill\Bloc;
use Bill\Flutterwave;
use Bill\Reloadly;
use Bill\Tpaga;
use Illuminate\Http\Request;
use Validator;

class BillServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bill-service-import', ['only' => ['store', 'import', 'bulkStore']]);
        $this->middleware('permission:bill-service-list', ['only' => ['index']]);
        $this->middleware('permission:bill-service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bill-convert-rate', ['only' => ['convertRate', 'saveRate']]);
    }

    public function index()
    {
        $services = BillService::latest()->paginate();

        return view('backend.bill.service.index', compact('services'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'category' => 'required',
            'data' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);

        }

        $data = $request->data;

        $this->insertService($data, $request);

        return response()->json([
            'success' => true,
            'message' => __('Service has been added.'),
        ]);

    }

    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'category' => 'required',
            'operator' => 'nullable',
            'services' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {

            notify()->error($validator->errors()->first(), 'Error');

            return back();

        }

        foreach ($request->services as $item) {

            $this->insertService(collect(json_decode($item))->toArray(), $request);
        }

        notify()->success(__('Bulk service has been added.'), 'Success');

        return to_route('admin.bill.service.index');
    }

    private function insertService($data, $request)
    {
        $countries = getCountries();

        $country = collect($countries)->where('code', $data['country'])->value('name', $data['country']);

        BillService::updateOrCreate([
            'api_id' => $data['id'],
        ], [
            'name' => $data['biller_name'],
            'code' => $data['biller_code'],
            'country' => $country,
            'country_code' => $data['country'],
            'data' => json_encode($data),
            'currency' => getCurrency($country),
            'amount' => $data['amount'],
            'method' => $request->method,
            'type' => $request->category,
            'label' => $data['label_name'],
            'status' => true,
        ]);

    }

    public function edit($id)
    {
        $service = BillService::find($id);

        return view('backend.bill.service.include.__edit_form', compact('service'))->render();
    }

    public function update(Request $request, $id)
    {
        $service = BillService::findOrFail($id);

        $service->update([
            'status' => $request->boolean('status'),
            'min_amount' => $request->integer('min_amount'),
            'max_amount' => $request->integer('max_amount'),
            'charge' => $request->integer('charge'),
            'charge_type' => $request->charge_type,
        ]);

        notify()->success('Bill service updated successfully');

        return back();
    }

    public function import()
    {
        $methods = Plugin::whereIn('name', ['Flutterwave', 'Reloadly', 'Bloc', 'Tpaga'])->where('status', 1)->get();

        if (request('type') === 'get_service') {

            $response = match (request('method')) {
                'flutterwave' => (new Flutterwave())->getAllCategories(request('category')),
                'reloadly' => (new Reloadly())->getBiller(request('category')),
                'bloc' => (new Bloc())->getOperatorProducts(request('category'), request('operator')),
                'tpaga' => (new Tpaga())->getProvider(request('category')),
                default => [
                    'status' => false,
                    'message' => __('Sorry, something went wrong!'),
                    'data' => [],
                ]
            };

            if ($response['status']) {

                $services = $response['data'];

                return view('backend.bill.service.import', compact('methods', 'services'));

            }

            notify()->error($response['message'], 'Error');

            return back();

        }

        return view('backend.bill.service.import', compact('methods'));
    }

    public function getCategories($method)
    {
        $categories = [
            'flutterwave' => [
                'airtime' => 'Airtime',
                'data_bundle' => 'Data Bundle',
                'power' => 'Power',
                'internet' => 'Internet',
                'cables' => 'Cables',
                'toll' => 'Toll',
            ],
            'reloadly' => [
                'AIRTIME' => 'Airtime',
                'ELECTRICITY_BILL_PAYMENT' => 'Electricity',
                'WATER_BILL_PAYMENT' => 'Water',
                'TV_BILL_PAYMENT' => 'Television',
                'INTERNET_BILL_PAYMENT' => 'Internet',
            ],
            'bloc' => [
                'telco' => 'Airtime/Data Bundle',
                'electricity' => 'Electricity',
                'television' => 'Television',
            ],
            'tpaga' => [
                'gas' => 'Gas',
                'power' => 'Power',
                'mobile' => 'Mobile',
                'internet' => 'Internet',
                'tv' => 'Television',
                'phone' => 'Phone',
                'water' => 'Water',
                'other' => 'Other',
            ],
        ];

        $category = $categories[$method];
        $html = '<option value="" selected disabled>Select Category</option>';

        foreach ($category as $key => $cate) {
            $html .= "<option value='{$key}'>{$cate}</option>";
        }

        return $html;
    }

    public function convertRate()
    {
        $methods = Plugin::whereIn('name', ['Flutterwave', 'Reloadly', 'Bloc', 'Tpaga'])->get();
        $currencies = null;
        $rates = [];

        if (request('type') == 'get_currencies') {
            $currencies = match (request('method')) {
                'flutterwave' => [
                    'NGN', 'ZMW', 'KES', 'GHS',
                ],
                'bloc' => [
                    'NGN',
                ],
                'tpaga' => [
                    'COP',
                ],
                'reloadly' => [
                    'NGN', 'UGX', 'XOF', 'BDT', 'INR', 'COP', 'EUR', 'KES', 'ILS', 'KZT', 'AFN', 'CDF', 'SLL', 'USD', 'XAF', 'MGA', 'MWK', 'NIO',
                    'LKR', 'TZS', 'ZMW', 'GHS', 'RWF', 'THB', 'ALL', 'LBP', 'MYR', 'DOP', 'MXN', 'GBP', 'IQD', 'TJS', 'AZN', 'BHD', 'KGS', 'UZS', 'CAD',
                    'BWP', 'PEN', 'TTD', 'ZAR', 'KHR', 'GTQ', 'CNY', 'MRO', 'ARS', 'BRL', 'DZD', 'CRC', 'HNL', 'PAB', 'KMF', 'CUP', 'CVE', 'XCD', 'BBD', 'FJD', 'GYD',
                    'HTG', 'JMD', 'WST', 'SRD',
                ]
            };

            $plugin = Plugin::where('name', ucfirst(request('method')))->first();
            $rates = data_get(json_decode($plugin?->data, true), 'currencies');
        }

        return view('backend.bill.convert-rate', compact('methods', 'currencies', 'rates'));
    }

    public function saveRate(Request $request)
    {
        $request->validate([
            'method' => 'required',
            'rate' => 'required|array|min:1',
        ]);

        $plugin = Plugin::where('name', ucfirst($request->method))->firstOrFail();

        $data = json_decode($plugin->data, true);
        $data['currencies'] = $request->rate;
        $plugin->data = json_encode($data);
        $plugin->save();

        notify()->success(__('Conversion Rate added successfully!'), 'Success');

        return to_route('admin.bill.convert.rate');
    }
}
