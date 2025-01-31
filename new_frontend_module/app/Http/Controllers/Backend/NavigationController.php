<?php

namespace App\Http\Controllers\Backend;

use App\Enums\NavigationType;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Navigation;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class NavigationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:navigation-manage');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $pages = Page::where('locale', 'en')->where('status', true)->get();
        $navigations = Navigation::all();

        return view('backend.navigation.menu', compact('pages', 'navigations'));
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'select_page' => 'required',
            'custom_url' => 'required_if:select_page,custom',
            'type' => new Enum(NavigationType::class),
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }
        $input = $request->all();
        $url = $input['custom_url'];
        $pageId = $input['select_page'];
        if ($input['select_page'] != 'custom') {
            $page = Page::find($input['select_page']);
            $url = $page->url;
        } else {
            $pageId = null;
        }

        $data = [
            'name' => $input['name'],
            'page_id' => $pageId,
            'url' => $url,
            'type' => $input['type'],
            'status' => $input['status'],
        ];

        if ($input['type'] == NavigationType::Both->value) {
            $headerPosition = Navigation::max('header_position');
            $footerPosition = Navigation::max('footer_position');
            $data = array_merge($data, ['header_position' => $headerPosition + 1, 'footer_position' => $footerPosition + 1]);

        } elseif ($input['type'] == NavigationType::Header->value) {
            $headerPosition = Navigation::max('header_position');
            $data = array_merge($data, ['header_position' => $headerPosition + 1]);
        } else {
            $footerPosition = Navigation::max('footer_position');
            $data = array_merge($data, ['footer_position' => $footerPosition + 1]);
        }

        Navigation::create($data);

        notify()->success(__('New Menu Created Successfully'));

        return redirect()->back();

    }

    /**
     * @return string
     */
    public function edit($id)
    {

        $navigation = Navigation::find($id);
        $pages = Page::where('locale', 'en')->where('status', true)->get();

        return view('backend.navigation.include.__edit_section', compact('navigation', 'pages'))->render();

    }

    /**
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        Navigation::find($id)->delete();
        notify()->success(__('Menu Delete Successfully'));

        return redirect()->back();
    }

    /**
     * @return Application|Factory|View
     */
    public function header()
    {
        $navigations = Navigation::where('type', NavigationType::Header)->orWhere('type', NavigationType::Both)->orderBy('header_position')->get();

        return view('backend.navigation.header', compact('navigations'));
    }

    /**
     * @return Application|Factory|View
     */
    public function footer()
    {
        $navigations = Navigation::where('type', NavigationType::Footer)->orWhere('type', NavigationType::Both)->orderBy('footer_position')->get();

        return view('backend.navigation.footer', compact('navigations'));
    }

    /**
     * @return RedirectResponse
     */
    public function positionUpdate(Request $request)
    {
        $inputs = $request->except('_token', 'type');
        $type = $request->type;

        $navigationInstance = new Navigation();
        $i = 1;

        foreach ($inputs as $input) {
            $navigation = $navigationInstance->find((int) $input);

            if ($type == 'header') {
                $navigation->update([
                    'header_position' => $i,
                ]);
            } else {
                $navigation->update([
                    'footer_position' => $i,
                ]);
            }

            $i++;
        }

        notify()->success(__('Menu Draggable Successfully'));

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'select_page' => 'required',
            'custom_url' => 'required_if:select_page,custom',
            'type' => new Enum(NavigationType::class),
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }
        $input = $request->all();
        $url = $input['custom_url'];
        $pageId = $input['select_page'];
        if ($input['select_page'] != 'custom') {
            $page = Page::find($input['select_page']);
            $url = $page->url;
        } else {
            $pageId = null;
        }

        $data = [
            'name' => $input['name'],
            'page_id' => $pageId,
            'url' => $url,
            'type' => $input['type'],
            'status' => $input['status'],
        ];

        $navigation = Navigation::find($input['id']);

        if ($input['type'] != $navigation->type && $input['type'] == NavigationType::Both->value) {
            $headerPosition = Navigation::max('header_position');
            $footerPosition = Navigation::max('footer_position');
            $data = array_merge($data, ['header_position' => $headerPosition + 1, 'footer_position' => $footerPosition + 1]);

        } elseif ($input['type'] != $navigation->type && $input['type'] == NavigationType::Header->value) {
            $headerPosition = Navigation::max('header_position');
            $data = array_merge($data, ['header_position' => $headerPosition + 1, 'footer_position' => null]);
        } elseif ($input['type'] != $navigation->type && $input['type'] == NavigationType::Footer->value) {
            $footerPosition = Navigation::max('footer_position');
            $data = array_merge($data, ['footer_position' => $footerPosition + 1, 'header_position' => null]);
        }

        Navigation::find($input['id'])->update($data);

        notify()->success(__('Menu updated successfully!'));

        return redirect()->back();

    }

    /**
     * @return RedirectResponse
     */
    public function typeDelete($id, $type)
    {
        $navigation = Navigation::find($id);

        if ($navigation->type == $type) {
            notify()->error('This Menu Only Available.'.ucwords($type).' Position', 'Can Not Delete');

            return redirect()->back();
        }

        if ($type == 'header') {
            $navigation->update([
                'header_position' => null,
                'type' => NavigationType::Footer->value,
            ]);
        } else {
            $navigation->update([
                'footer_position' => null,
                'type' => NavigationType::Header->value,
            ]);
        }

        notify()->success(__('Menu deleted successfully!'));

        return redirect()->back();
    }

    public function translate($id)
    {
        $navigation = Navigation::find($id);
        $languages = Language::where('status', true)->get();

        $locale = array_column($languages->toArray(), 'locale');

        $navigationContent = $navigation->translate == null ? [] : json_decode($navigation->translate, true);

        $localeKey = array_fill_keys($locale, '');

        $localeContent = array_merge($localeKey, $navigationContent);

        return view('backend.navigation.translate', compact('languages', 'navigation', 'localeContent'));
    }

    public function translateNow(Request $request)
    {

        $input = $request->all();

        $navigation = Navigation::find($input['id']);

        $oldTranslate = $navigation->translate == null ? [] : json_decode($navigation->translate, true);

        $value = [];
        $value[$input['locale']] = $input['name'];

        $result = array_merge($oldTranslate, $value);

        $navigation->update([
            'translate' => json_encode($result),
        ]);
        notify()->success(__('Menu translate successfully!'));

        return redirect()->back();

    }
}
