<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:branch-list', ['only' => ['index']]);
        $this->middleware('permission:branch-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:branch-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'asc';
        $search = $request->search ?? null;
        $status = $request->status ?? 'all';
        $branches = Branch::order($order)
            ->search($search)
            ->status($status)
            ->latest()
            ->paginate($perPage);

        return view('backend.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => ['required', 'unique:branches,code'],
            'routing_number' => 'required',
            'swift_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        $data = [
            'name' => $input['name'],
            'code' => $input['code'],
            'routing_number' => $input['routing_number'],
            'swift_code' => $input['swift_code'],
            'phone' => $input['phone'],
            'mobile' => $input['mobile'],
            'email' => $input['email'],
            'fax' => $input['fax'],
            'address' => $input['address'],
            'map_location' => $input['map_location'],
            'status' => $input['status'],
        ];

        Branch::create($data);
        notify()->success(__('Branch Added successfully'));

        return redirect()->route('admin.branch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return view('backend.branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => ['required'],
            'routing_number' => 'required',
            'swift_code' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        $data = [
            'name' => $input['name'],
            'code' => $input['code'],
            'routing_number' => $input['routing_number'],
            'swift_code' => $input['swift_code'],
            'phone' => $input['phone'],
            'mobile' => $input['mobile'],
            'email' => $input['email'],
            'fax' => $input['fax'],
            'address' => $input['address'],
            'map_location' => $input['map_location'],
            'status' => $input['status'],
        ];

        $branch->update($data);
        notify()->success(__('Branch Updated successfully'));

        return redirect()->route('admin.branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->staffs()->delete();
        $branch->delete();
        notify()->success(__('Branch Deleted successfully'));

        return redirect()->back();
    }
}
