<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Language;
use App\Traits\ImageUpload;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
    use ImageUpload;

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.page.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cover' => 'required|image|mimes:jpg,png,svg',
            'title' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $maxId = Blog::max('id');

        if (! $maxId) {
            Blog::query()->truncate();
            $maxId = 1;
        } else {
            $maxId = $maxId + 1;
        }

        $data = [
            'cover' => self::imageUploadTrait($input['cover']),
            'title' => $input['title'],
            'details' => $input['details'],
            'locale_id' => $maxId,
        ];

        Blog::create($data);

        notify()->success(__('Blog added successfully!'));

        return redirect()->route('admin.page.edit', 'blog');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Blog  $blog
     * @return Application|Factory|View
     */
    public function edit($id)
    {

        $blog = Blog::where('locale_id', $id)->get();

        $engBlog = Blog::where('locale_id', $id)->where('locale', '=', 'en')->firstOrFail(['id', 'cover', 'title', 'details'])->toArray();

        $groupData = $blog->groupBy('locale');
        $groupData = $groupData->map(function ($items) {
            return $items->first()->only(['id', 'cover', 'title', 'details']);
        })->toArray();

        $languages = Language::where('status', true)->get();

        $locale = array_column($languages->toArray(), 'locale');
        $localeKey = array_fill_keys($locale, $engBlog);
        $groupData = array_merge($localeKey, $groupData);

        return view('backend.page.blog.edit', compact('groupData', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Blog  $blog
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $locale = $input['locale'];
        $blog = Blog::where('locale', $locale)->where('id', $id)->first();
        $engBlog = Blog::where('id', $id)->where('locale', '=', 'en')->first();

        if (! $blog) {
            $blog = $engBlog->replicate();
            $blog->locale = $locale;
            $blog->created_at = $engBlog->un_modify_created_at;
            $blog->save();
        }

        $data = [
            'title' => $input['title'],
            'details' => $input['details'],
        ];

        if (isset($input['cover']) && is_file($input['cover'])) {
            $data['cover'] = self::imageUploadTrait($input['cover'], $blog->cover);
        }

        $blog->update($data);

        notify()->success(__('Blog updated successfully!'));

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blog  $blog
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $blog = Blog::where('id', $id);
        if (file_exists('assets/'.$blog->first()?->cover)) {
            @unlink('assets/'.$blog->first()->cover);
        }
        Blog::where('id', $id)->delete();
        notify()->success(__('Blog deleted successfully!'));

        return redirect()->route('admin.page.edit', 'blog');
    }
}
