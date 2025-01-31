<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dps;
use Illuminate\Http\Request;

class DpsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ongoing-dps', ['only' => ['ongoing']]);
        $this->middleware('permission:payable-dps', ['only' => ['payable']]);
        $this->middleware('permission:complete-dps', ['only' => ['complete']]);
        $this->middleware('permission:closed-dps', ['only' => ['close']]);
        $this->middleware('permission:all-dps', ['only' => ['all']]);
        $this->middleware('permission:view-dps-details', ['only' => ['details']]);
    }

    public function ongoing(Request $request)
    {
        $search = $request->search;

        $dpses = Dps::with(['plan', 'user'])
                    ->ongoing()
                    ->search($search)
                    ->when(in_array($request->sort_field,['dps_id','created_at','given_installment','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = 'Ongoing';

        return view('backend.dps.index', compact('dpses', 'statusForFrontend'));
    }

    public function payable(Request $request)
    {
        $search = $request->search;

        $dpses = Dps::with(['plan', 'user'])
                    ->payable()
                    ->search($search)
                    ->when(in_array($request->sort_field,['dps_id','created_at','given_installment','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = 'Payable';

        return view('backend.dps.index', compact('dpses', 'statusForFrontend'));
    }

    public function complete(Request $request)
    {
        $search = $request->search;
        $dpses = Dps::with(['plan', 'user'])
                    ->complete()
                    ->search($search)
                    ->when(in_array($request->sort_field,['dps_id','created_at','given_installment','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = 'Complete';

        return view('backend.dps.index', compact('dpses', 'statusForFrontend'));
    }

    public function close(Request $request)
    {
        $search = $request->search;
        $dpses = Dps::with(['plan', 'user'])
                    ->closed()
                    ->search($search)
                    ->when(in_array($request->sort_field,['dps_id','created_at','given_installment','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = 'Close';

        return view('backend.dps.index', compact('dpses', 'statusForFrontend'));
    }

    public function all(Request $request)
    {
        $search = $request->search;

        $dpses = Dps::with(['plan', 'user'])
                    ->when(in_array($request->sort_field,['dps_id','created_at','given_installment','status']),function($query){
                        $query->orderBy(request('sort_field'),request('sort_dir'));
                    })
                    ->search($search)
                    ->latest()
                    ->paginate(10);

        $statusForFrontend = 'All';

        return view('backend.dps.index', compact('dpses', 'statusForFrontend'));
    }

    public function details($id)
    {
        $dps = Dps::find($id);

        return view('backend.dps.details', compact('dps'))->render();
    }
}
