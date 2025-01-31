<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Arr;
use DB;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:staff-list|staff-create|staff-edit', ['only' => ['index', 'store']]);
        $this->middleware('permission:staff-create', ['only' => ['store']]);
        $this->middleware('permission:staff-edit', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = Role::whereNot('name', 'Super-Admin')->get();
        $staffs = Admin::all();

        return view('backend.staff.index', compact('roles', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:confirm-password',
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
        notify()->success('Staff created successfully');

        return redirect()->route('admin.staff.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {
        $roles = Role::whereNot('name', 'Super-Admin')->get();
        $staff = Admin::find($id);
        $staff->getRoleNames()->first();

        return view('backend.staff.include.__edit_form', compact('staff', 'roles'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'same:confirm-password',
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

        $staff = Admin::find($id);

        if ($staff->getRoleNames()->first() === 'Super-Admin') {
            notify()->warning('Super admin not changeable');

            return redirect()->back();
        }

        $staff->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $staff->assignRole($request->input('role'));

        notify()->success('Staff updated successfully');

        return redirect()->route('admin.staff.index');
    }
}
