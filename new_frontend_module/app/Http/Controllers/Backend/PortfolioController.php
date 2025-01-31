<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Traits\ImageUpload;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class PortfolioController extends Controller
{
    use ImageUpload;

    public function __construct()
    {
        $this->middleware('permission:manage-portfolio', ['only' => ['index']]);
        $this->middleware('permission:portfolio-create', ['only' => ['store']]);
        $this->middleware('permission:portfolio-edit', ['only' => ['update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $portfolios = Portfolio::all();

        return view('backend.portfolio.index', compact('portfolios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'icon' => 'required|image|mimes:jpg,png,svg',
            'level' => 'required|unique:portfolios,level',
            'portfolio_name' => 'required|unique:portfolios,portfolio_name',
            'minimum_transactions' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:portfolios,minimum_transactions',
            'bonus' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        Portfolio::create([
            'icon' => self::imageUploadTrait($request->file('icon')),
            'level' => $request->get('level'),
            'portfolio_name' => $request->get('portfolio_name'),
            'minimum_transactions' => $request->get('minimum_transactions'),
            'bonus' => $request->get('bonus'),
            'description' => $request->get('description'),
            'status' => $request->boolean('status'),
        ]);

        notify()->success('Portfolio created successfully', 'Success');

        return redirect()->route('admin.portfolio.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Portfolio $portfolio)
    {

        $validator = Validator::make($request->all(), [
            'level' => 'required|unique:portfolios,level,'.$portfolio->id,
            'portfolio_name' => 'required|unique:portfolios,portfolio_name,'.$portfolio->id,
            'minimum_transactions' => 'required|regex:/^\d+(\.\d{1,2})?$/|unique:portfolios,minimum_transactions,'.$portfolio->id,
            'bonus' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $data = [
            'level' => $request->get('level'),
            'portfolio_name' => $request->get('portfolio_name'),
            'minimum_transactions' => $request->get('minimum_transactions'),
            'bonus' => $request->get('bonus'),
            'description' => $request->get('description'),
            'status' => $request->boolean('status'),
        ];

        if ($request->hasFile('icon')) {
            $icon = self::imageUploadTrait($request->file('icon'), $portfolio->icon);
            $data = array_merge($data, ['icon' => $icon]);
        }

        $portfolio->update($data);

        notify()->success('Portfolio updated successfully!', 'Success');

        return redirect()->route('admin.portfolio.index');
    }
}
