<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserNavigation;
use Illuminate\Http\Request;
use Validator;

class UserNavigationController extends Controller
{
    public function index()
    {
        $navigations = UserNavigation::orderBy('position')->get();

        return view('backend.user_navigations.index', compact('navigations'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|exists:user_navigations',
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return back();
        }

        UserNavigation::where('type', $request->string('type'))->update([
            'name' => $request->name,
        ]);

        notify()->success(__('User navigation updated successfully!'), 'Success');

        return back();
    }

    public function positionUpdate(Request $request)
    {

        $ids = $request->except('_token');
        // dd($ids);

        $type = $request->type;

        $navigations = new UserNavigation();
        $i = 1;

        foreach ($ids as $id) {
            $navigation = $navigations->find((int) $id);

            $navigation->update([
                'position' => $i,
            ]);

            $i++;
        }

        notify()->success(__('Menu Draggable Successfully'), 'Success');

        return redirect()->back();
    }
}
