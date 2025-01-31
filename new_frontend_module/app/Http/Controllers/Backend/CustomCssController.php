<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomCss;
use Illuminate\Http\Request;

class CustomCssController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:custom-css');
    }

    public function customCss()
    {
        $customCss = CustomCss::first()->css;

        return view('backend.css_manage.index', compact('customCss'));
    }

    public function customCssUpdate(Request $request)
    {

        CustomCss::first()->update([
            'css' => $request->custom_css,
        ]);

        notify()->success(__('Css Update Successfully'));

        return redirect()->back();
    }
}
