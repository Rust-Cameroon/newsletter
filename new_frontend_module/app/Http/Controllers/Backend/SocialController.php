<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'icon_name' => 'required',
            'class_name' => 'required',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $social = new Social();

        $data = [
            'icon_name' => $input['icon_name'],
            'class_name' => $input['class_name'],
            'url' => $input['url'],
            'position' => $social->count() + 1,
        ];

        $social->create($data);
        notify()->success(__('Social Create Successfully'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        Social::find($id)->delete();
        notify()->success(__('Social Delete Successfully'));

        return redirect()->back();
    }

    public function positionUpdate(Request $request)
    {
        $inputs = $request->except('_token');
        $social = new Social();
        $i = 0;
        foreach ($inputs as $input) {
            $social->find($input)->update([
                'position' => $i,
            ]);
            $i++;
        }

        notify()->success(__('Social Draggable Successfully'));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon_name' => 'required',
            'class_name' => 'required',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $data = [
            'icon_name' => $input['icon_name'],
            'class_name' => $input['class_name'],
            'url' => $input['url'],
        ];

        Social::find($input['id'])->update($data);
        notify()->success(__('Social Update Successfully'));

        return redirect()->back();
    }
}
