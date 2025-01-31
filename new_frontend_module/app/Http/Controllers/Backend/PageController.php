<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LandingContent;
use App\Models\LandingPage;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageSetting;
use App\Models\Social;
use App\Traits\ImageUpload;
use Arr;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use Str;

class PageController extends Controller
{
    use ImageUpload;

    public function __construct()
    {
        $this->middleware('permission:footer-manage|landing-page-manage', ['only' => ['landingSectionUpdate']]);
        $this->middleware('permission:landing-page-manage', ['only' => ['landingSection', 'contentStore', 'contentUpdate', 'contentDelete']]);
        $this->middleware('permission:page-manage', ['only' => ['create', 'store', 'edit', 'update', 'deleteNow']]);
        $this->middleware('permission:footer-manage', ['only' => ['footerContent']]);
        $this->middleware('permission:page-setting', ['only' => ['pageSetting', 'pageSettingUpdate', 'settingUpdate']]);
    }

    //================================== page section ===============================================

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();
        $slug = str::slug($input['title'], '-');

        $page = new Page();

        if ($page->where('code', $slug)->exists()) {
            notify()->error('Same Name Already Exists', 'Error');

            return redirect()->back();
        }

        $content = [
            'meta_keywords' => $input['meta_keywords'],
            'meta_description' => $input['meta_description'],
            'section_id' => json_encode($request->get('section_id',[])),
            'content' => Purifier::clean(htmlspecialchars_decode($input['content'])),
        ];

        $page->create([
            'title' => $input['title'],
            'url' => '/page/'.$slug,
            'code' => $slug,
            'data' => json_encode($content),
            'status' => $input['status'],
        ]);

        Cache::pull('pages');

        notify()->success(__('New Page Created Successfully'));

        return redirect()->back();
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $landingSections = Cache::get('landingSections');

        return view('backend.page.create', compact('landingSections'));
    }

    /**
     * @return Application|Factory|View
     */
    public function edit($name)
    {

        $page = Page::where('code', $name)->get();
        $engPage = Page::where('code', $name)->where('locale', '=', 'en')->first();

        $status = $engPage->status;
        $slug = $engPage->url;
        $groupData = $page->groupBy('locale');

        $groupData = $groupData->map(function ($items) {

            $item = $items->first();
            if ($item->type == 'dynamic') {
                return array_merge(json_decode($items->first()->data, true), ['title' => $item->title]);
            }

            return json_decode($item->data, true);
        })->toArray();

        $languages = Language::where('status', true)->get();
        $locale = array_column($languages->toArray(), 'locale');
        $engData = json_decode($engPage->data, true);
        $localeKey = array_fill_keys($locale, $engData);
        $groupData = array_merge($localeKey, $groupData);

        $commaIds = isset($engData['section_id']) ? implode(',',json_decode($engData['section_id'])) : '';
        $landingSections = LandingPage::where('status', true)->where('code','!=','footer')->where('locale','en')->when(isset($engData['section_id']) && json_decode($engData['section_id']),function($query) use($commaIds){
            $query->orderByRaw("FIELD(id, $commaIds)");
        })->get();

        if ($engPage->type == 'dynamic') {
            $title = $engPage->title;
            $code = $engPage->code;

            return view('backend.page.edit', compact('landingSections', 'title', 'groupData', 'status', 'code', 'languages'));
        }

        return view('backend.page.'.$name, compact('status','landingSections', 'slug', 'groupData', 'languages'));

    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request)
    {

        $input = $request->all();

        $content = $request->except(['page_code', 'status', '_token', 'page_locale']);
        $pageCode = $input['page_code'];
        $pageLocale = $input['page_locale'];

        $engPage = Page::where('code', $pageCode)->where('locale', '=', 'en')->first();
        $page = Page::where('code', $pageCode)->where('locale', $pageLocale)->first();

        if (! $page) {
            $page = $engPage->replicate();
            $page->locale = $pageLocale;
            $page->save();
        }

        $page = Page::where('code', $pageCode)->where('locale', $pageLocale)->first();

        if ($page->type == 'dynamic') {
            $content = [
                'section_id' => json_encode($request->get('section_id',[])),
                'meta_keywords' => $input['meta_keywords'],
                'meta_description' => $input['meta_description'],
                'content' => Purifier::clean(htmlspecialchars_decode($input['content'])),
            ];

            if ($pageLocale != 'en') {
                $engOldData = json_decode($engPage->data, true);
                $content = array_merge($engOldData, $content);
            } else {
                $content['section_id'] = json_encode($request->get('section_id',[]));
            }

            $data = [
                'title' => $input['title'],
                'data' => json_encode($content),
                'status' => (bool) $input['status'],
            ];

        } else {

            $oldData = json_decode($page->data, true);
            $engOldData = json_decode($engPage->data, true);

            foreach ($content as $key => $value) {
                if (is_array($value)) {
                    $content[$key] = json_encode($value);
                } elseif (is_file($value)) {
                    $oldValue = Arr::get($oldData, $key);
                    $content[$key] = self::imageUploadTrait($value, $oldValue);

                } elseif ($key == 'content') {
                    $content[$key] = Purifier::clean(htmlspecialchars_decode($value));
                }
            }

            $content = array_merge($engOldData, $content);
            $content = array_merge($oldData, $content);

            $data = [
                'data' => json_encode($content),
            ];

            if ($pageLocale == 'en' && isset($input['status'])) {
                Page::where('code', $pageCode)->update([
                    'status' => (bool) $input['status'],
                ]);

            }

        }

        $page->update($data);

        if ($page->type == 'dynamic') {
            Cache::pull('pages');
        }

        notify()->success($page->title.' '.__(' updated successfully'));

        return redirect()->back();

    }

    /**
     * @return RedirectResponse
     */
    public function deleteNow(Request $request)
    {
        $pageCode = $request['page_code'];
        $page = Page::where('code', $pageCode)->delete();
        Cache::pull('pages');
        notify()->success(__('Deleted Successfully'));

        return redirect()->route('admin.page.create');
    }

    //================================== Landing Section ===============================================

    /**
     * @return Application|Factory|View
     */
    public function landingSection($section)
    {

        $landingPage = LandingPage::where('code', $section)->get();
        $engLandingPage = $landingPage->where('locale', '=', 'en')->first();
        $status = $engLandingPage->status;
        $groupData = $landingPage->groupBy('locale');

        $groupData = $groupData->map(function ($items) {
            return json_decode($items->first()->data, true);
        })->toArray();

        $languages = Language::where('status', true)->get();

        $locale = array_column($languages->toArray(), 'locale');
        $engData = json_decode($engLandingPage->data, true);
        $localeKey = array_fill_keys($locale, $engData);

        $groupData = array_merge($localeKey, $groupData);

        $landingContent = LandingContent::where('type', $section)->where('locale', 'en')->get();

        return view('backend.page.section.'.$section, compact('groupData', 'languages', 'status', 'landingContent'));
    }

    public function landingSectionUpdate(Request $request)
    {

        $input = $request->all();

        if ($request->ajax()) {

            $engLandingPage = LandingPage::where('code', $input['target_code'])->where('locale', '=', 'en')->first();

            $data = json_decode($engLandingPage->data, true);

            if (file_exists('assets/'.$data[$input['field_name']])) {
                @unlink('assets/'.$input['field_name']);

                $data = array_merge($data, [$input['field_name'] => null]);

                $update = $engLandingPage->update([
                    'data' => json_encode($data),
                ]);

                return response()->json([
                    'status' => $update,
                ]);
            }
        }

        $data = $request->except(['section_code', 'status', '_token', 'section_locale']);

        $sectionCode = $input['section_code'];
        $sectionlocale = $input['section_locale'];

        $engLandingPage = LandingPage::where('code', $sectionCode)->where('locale', '=', 'en')->first();
        $landingPage = LandingPage::where('code', $sectionCode)->where('locale', $sectionlocale)->first();

        if (! $landingPage) {
            $landingPage = $engLandingPage->replicate();
            $landingPage->locale = $sectionlocale;
            $landingPage->save();
        }

        $oldData = json_decode($landingPage->data, true);
        $engOldData = json_decode($engLandingPage->data, true);

        foreach ($data as $key => $value) {

            if (is_file($value)) {
                $oldValue = Arr::get($oldData, $key);
                $data[$key] = self::imageUploadTrait($value, $oldValue);
            }
        }

        $data = array_merge($engOldData, $data);

        $landingPage->update([
            'data' => json_encode($data),
        ]);

        if ($sectionlocale == 'en') {
            LandingPage::where('code', $sectionCode)->update([
                'status' => $input['status'] ?? $engLandingPage->status,
            ]);
        }

        notify()->success($landingPage->name.' '.__(' updated successfully'));

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function contentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $data = [
            'locale_id' => LandingContent::max('id') + 1,
            'icon' => $input['icon'] ?? null,
            'title' => $input['title'],
            'description' => $request->get('description'),
            'photo' => $input['photo'] ?? null,
            'type' => $input['type'],
        ];

        if ($request->hasFile('icon')) {
            $data = array_merge($data, ['icon' => self::imageUploadTrait($input['icon'])]);
        }

        if ($request->hasFile('photo')) {
            $data = array_merge($data, ['photo' => self::imageUploadTrait($input['photo'])]);
        }

        LandingContent::create($data);
        notify()->success(__('Content added successfully'));

        return redirect()->back();
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contentEdit($id)
    {
        $languages = Language::where('status', true)->get();
        $landingContent = LandingContent::where('id', $id)->get();
        $engLandingContent = LandingContent::where('id', $id)->where('locale', '=', 'en')->first(['id', 'icon', 'title', 'description','photo', 'type'])->toArray();

        $groupData = $landingContent->groupBy('locale');
        $groupData = $groupData->map(function ($items) {
            return $items->first()->only(['id', 'icon', 'title', 'description', 'type','photo']);
        })?->toArray();

        $locale = array_column($languages->toArray(), 'locale');
        $localeKey = array_fill_keys($locale, $engLandingContent);
        $groupData = array_merge($localeKey, $groupData);

        $html = view('backend.page.section.include.__conten_edit_render', compact('groupData', 'languages'))->render();

        return response()->json(['html' => $html]);

    }

    public function contentUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $locale = $input['locale'];
        $landingContent = LandingContent::where('locale', $locale)->where('id', $input['id'])->first();
        $engLandingContent = LandingContent::where('id', $input['id'])->where('locale', '=', 'en')->first();

        if (! $landingContent) {
            $landingContent = $engLandingContent->replicate();
            $landingContent->locale = $locale;
            $landingContent->created_at = $engLandingContent->created_at;
            $landingContent->save();
        }

        $data = [
            'icon' => $input['icon'] ?? $landingContent->icon,
            'photo' => $input['photo'] ?? $landingContent->photo,
            'title' => $input['title'],
            'description' => $request->get('description'),
        ];

        if (isset($input['icon']) && is_file($input['icon'])) {
            $data['icon'] = self::imageUploadTrait($input['icon'], $landingContent->icon);
        }

        if (isset($input['photo']) && is_file($input['photo'])) {
            $data['photo'] = self::imageUploadTrait($input['photo'], $landingContent->photo);
        }

        $landingContent->update($data);

        notify()->success(__('Content Updated Successfully'));

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function contentDelete(Request $request)
    {
        $id = $request->id;
        LandingContent::where('id', $id)->delete();
        notify()->success(__('Content Deleted Successfully'));

        return redirect()->back();
    }

    //================================== End Landing Section ===============================================

    /**
     * @return Application|Factory|View
     */
    public function pageSetting()
    {
        return view('backend.page.setting');
    }

    /**
     * @return RedirectResponse
     */
    public function pageSettingUpdate(Request $request)
    {

        $input = $request->except('_token');
        foreach ($input as $key => $value) {
            if ($request->hasFile($key)) {
                $value = self::imageUploadTrait($value, getPageSetting($key));
            }
            $this->settingUpdate($key, $value);
        }

        notify()->success(__('Setting updated successfully'), 'Success');

        return redirect()->back();
    }

    /**
     * @return void
     */
    private function settingUpdate($key, $value)
    {
        PageSetting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * @return Application|Factory|View
     */
    public function footerContent()
    {
        $socials = Social::orderBy('position')->get();

        $landingPage = LandingPage::where('code', 'footer')->get();
        $engLandingPage = $landingPage->where('locale', '=', 'en')->first();

        $status = $engLandingPage->status;

        $groupData = $landingPage->groupBy('locale');

        $groupData = $groupData->map(function ($items) {
            return json_decode($items->first()->data, true);
        })->toArray();

        $languages = Language::where('status', true)->get();

        $locale = array_column($languages->toArray(), 'locale');

        $engData = json_decode($engLandingPage->data, true);

        $localeKey = array_fill_keys($locale, $engData);

        $groupData = array_merge($localeKey, $groupData);

        return view('backend.page.section.footer', compact('groupData', 'socials', 'languages', 'status'));
    }

    public function management()
    {
        $sections = LandingPage::where('locale', 'en')->orderBy('short')->get();

        return view('backend.page.section.management',compact('sections'));
    }

    public function managementUpdate(Request $request)
    {
        foreach($request->section_order as $code => $order){
            LandingPage::where('code',$code)->update([
                'short' => $order
            ]);
        }

        notify()->success(__('Section order updated successfully!'));

        return redirect()->back();
    }
}
