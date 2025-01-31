<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\BranchStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BranchStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:branch-staff-list', ['only' => ['index']]);
        $this->middleware('permission:branch-staff-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:branch-staff-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:branch-staff-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $order = $request->order ?? 'desc';
        $search = $request->search ?? null;
        $branch = $request->branch ?? 0;
        $staffs = BranchStaff::order($order)
            ->branchId($branch)
            ->search($search)
            ->paginate($perPage);

        $branches = Branch::all();

        return view('backend.branch-staff.index', compact('staffs', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereNot('name', 'Super-Admin')->get();
        $branch = Branch::all();

        return view('backend.branch-staff.create', compact('roles', 'branch'));
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
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'role' => ['required', Rule::notIn('Super-Admin')],
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $admin = Admin::create($input);
        $admin->assignRole($request->input('role'));
        BranchStaff::create([
            'user_id' => $admin->id,
            'branch_id' => $input['branch'],
            'address' => $input['address'],
            'status' => $input['status'],
        ]);
        notify()->success('Staff created successfully');

        return redirect()->route('admin.branch-staff.index');
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
    public function edit($id)
    {
        $roles = Role::whereNot('name', 'Super-Admin')->get();
        $branch = Branch::all();
        $staff = BranchStaff::find($id);
        $staff->user->getRoleNames()->first();

        return view('backend.branch-staff.edit', compact('roles', 'branch', 'staff'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => ['required', Rule::notIn('Super-Admin')],
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        if (! empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $staff = BranchStaff::find($id);

        if ($staff->user->getRoleNames()->first() === 'Super-Admin') {
            notify()->warning('Super admin not changeable');

            return redirect()->back();
        }
        $staff->update($input);
        $admin = Admin::find($staff->user_id);
        $admin->update($input);
        DB::table('model_has_roles')->where('model_id', $admin->id)->delete();

        $admin->assignRole($request->input('role'));
        notify()->success('Staff updated successfully');

        return redirect()->route('admin.branch-staff.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = BranchStaff::find($id);
        $admin = Admin::find($staff->user_id);
        $staff->delete();
        $admin->delete();
        DB::table('model_has_roles')->where('model_id', $admin->id)->delete();

        notify()->success('Staff Deleted successfully');

        return redirect()->back();
    }
}
