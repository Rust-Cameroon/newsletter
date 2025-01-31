<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Validator;

class TestimonialController extends Controller
{
    use ImageUpload;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'picture' => 'nullable|mimes:png,jpg,jpeg',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        Testimonial::create([
            'name' => $request->get('name'),
            'designation' => $request->get('designation'),
            'message' => $request->get('message'),
            'picture' => $request->hasFile('picture') ? $this->imageUploadTrait($request->picture) : null,
        ]);

        notify()->success(__('Testimonial added successfully!'));

        return back();
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return view('backend.page.section.include.__edit_data_testimonial', compact('testimonial'))->render();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'picture' => 'nullable|mimes:png,jpg,jpeg',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $testimonial = Testimonial::findOrFail($request->id);

        if ($request->hasFile('picture')) {
            $this->delete($testimonial->picture);
        }

        $testimonial->update([
            'name' => $request->get('name'),
            'designation' => $request->get('designation'),
            'message' => $request->get('message'),
            'picture' => $request->hasFile('picture') ? $this->imageUploadTrait($request->picture) : $testimonial->picture,
        ]);

        notify()->success(__('Testimonial updated successfully!'));

        return back();
    }

    public function destroy(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->id);

        $this->delete($testimonial->picture);

        $testimonial->delete();

        notify()->success(__('Testimonial deleted successfully!'));

        return back();
    }
}
