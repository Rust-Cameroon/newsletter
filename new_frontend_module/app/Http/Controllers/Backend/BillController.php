<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pending-bills', ['only' => ['pending']]);
        $this->middleware('permission:complete-bills', ['only' => ['complete']]);
        $this->middleware('permission:return-bills', ['only' => ['returned']]);
        $this->middleware('permission:all-bills', ['only' => ['all']]);
    }

    public function all(Request $request)
    {
        $bill = Bill::with(['service', 'user'])
            ->latest()
            ->paginate(10);

        $statusForFrontend = 'All';

        return view('backend.bill.history', compact('bill', 'statusForFrontend'));
    }

    public function pending(Request $request)
    {
        $bill = Bill::with(['service', 'user'])
            ->pending()
            ->latest()
            ->paginate(10);

        $statusForFrontend = 'Pending';

        return view('backend.bill.history', compact('bill', 'statusForFrontend'));
    }

    public function complete(Request $request)
    {
        $bill = Bill::with(['service', 'user'])
            ->completed()
            ->latest()
            ->paginate(10);

        $statusForFrontend = 'Complete';

        return view('backend.bill.history', compact('bill', 'statusForFrontend'));
    }

    public function returned(Request $request)
    {
        $bill = Bill::with(['service', 'user'])
            ->returned()
            ->latest()
            ->paginate(10);

        $statusForFrontend = 'Returned';

        return view('backend.bill.history', compact('bill', 'statusForFrontend'));
    }
}
