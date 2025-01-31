<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fdr;
use Illuminate\Http\Request;

class FdrController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ongoing-fdr', ['only' => ['ongoing']]);
        $this->middleware('permission:payable-fdr', ['only' => ['payable']]);
        $this->middleware('permission:complete-fdr', ['only' => ['completed']]);
        $this->middleware('permission:closed-fdr', ['only' => ['close']]);
        $this->middleware('permission:all-fdr', ['only' => ['all']]);
        $this->middleware('permission:view-fdr-details', ['only' => ['details']]);
    }

    public function ongoing(Request $request)
    {
        $search = $request->search;

        $lists = Fdr::with(['plan', 'user'])
                        ->ongoing()
                        ->search($search)
                        ->when(in_array($request->sort_field,['fdr_id','created_at','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->latest()
                        ->paginate(10);

        $statusForFrontend = 'Ongoing';

        return view('backend.fdr.index', compact('lists', 'statusForFrontend'));
    }

    public function completed(Request $request)
    {
        $search = $request->search;

        $lists = Fdr::with(['plan', 'user'])
                        ->completed()
                        ->search($search)
                        ->when(in_array($request->sort_field,['fdr_id','created_at','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->latest()
                        ->paginate(10);

        $statusForFrontend = 'Completed';

        return view('backend.fdr.index', compact('lists', 'statusForFrontend'));
    }

    public function close(Request $request)
    {
        $search = $request->search;

        $lists = Fdr::with(['plan', 'user'])
                        ->closed()
                        ->search($search)
                        ->when(in_array($request->sort_field,['fdr_id','created_at','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->latest()
                        ->paginate(10);

        $statusForFrontend = 'Close';

        return view('backend.fdr.index', compact('lists', 'statusForFrontend'));
    }

    public function all(Request $request)
    {
        $search = $request->search;

        $lists = Fdr::with(['plan', 'user'])
                        ->search($search)
                        ->when(in_array($request->sort_field,['fdr_id','created_at','amount','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->latest()
                        ->paginate(10);

        $statusForFrontend = 'All';

        return view('backend.fdr.index', compact('lists', 'statusForFrontend'));
    }

    public function details($fdrId)
    {
        $fdr = Fdr::with(['user', 'plan', 'transactions'])->find($fdrId);

        return view('backend.fdr.details', compact('fdr'));
    }
}
