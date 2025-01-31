<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plugin;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:plugin-setting');
    }

    public function plugin($type)
    {

        $titles = [
            'system' => __('Third Party System Plugins'),
            'sms' => __('All Plugins adds the ability to send SMS'),
            'notification' => __('Most Popular Push Notification Plugin'),
        ];

        $title = $titles[$type];
        $plugins = Plugin::where('type', $type)->get();

        $isLink = false;
        if ($type == 'notification') {
            $isLink = true;
        }

        return view('backend.setting.plugin.index', compact('plugins', 'title', 'isLink'));
    }

    public function pluginData($id)
    {
        $plugin = Plugin::find($id);

        return view('backend.setting.plugin.include.__plugin_data', compact('plugin'))->render();
    }

    public function update(Request $request, $id)
    {
        $plugin = Plugin::find($id);
        $status = (bool) $request->status;

        if ($plugin->type == 'sms' && $status) {
            Plugin::where('type', 'sms')->update([
                'status' => 0,
            ]);
        }

        $plugin->update([
            'data' => json_encode($request->data),
            'status' => $status,
        ]);
        notify()->success(__('Settings has been saved'));

        return back();
    }
}
