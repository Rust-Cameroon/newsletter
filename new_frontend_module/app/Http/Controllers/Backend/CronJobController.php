<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CronJob;
use App\Models\CronJobLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CronJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-cron-job', ['only' => ['index']]);
        $this->middleware('permission:cron-job-create', ['only' => ['store']]);
        $this->middleware('permission:cron-job-edit', ['only' => ['update']]);
        $this->middleware('permission:cron-job-delete', ['only' => ['destroy']]);
        $this->middleware('permission:cron-job-logs', ['only' => ['logs']]);
        $this->middleware('permission:cron-job-run', ['only' => ['runNow']]);
    }
 
    public function index()
    {
        $jobs = CronJob::latest()->paginate();

        return view('backend.cron-jobs.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'schedule' => 'required',
            'next_run_at' => 'required|date',
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        CronJob::create([
            'name' => $request->name,
            'schedule' => $request->integer('schedule'),
            'next_run_at' => Carbon::parse($request->next_run_at)->toDateTimeString(),
            'url' => $request->url,
            'type' => 'custom',
            'status' => $request->status,
        ]);

        notify()->success(__('Cron Job added successfully!'), 'Success');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'schedule' => 'required',
            'next_run_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        CronJob::updateOrCreate([
            'id' => $request->id,
        ], [
            'name' => $request->name,
            'schedule' => $request->integer('schedule'),
            'next_run_at' => Carbon::parse($request->next_run_at)->toDateTimeString(),
            'url' => $request->url,
            'status' => $request->status,
        ]);

        notify()->success(__('Cron Job updated successfully!'), 'Success');

        return redirect()->back();
    }

    public function delete($id)
    {
        $cron = CronJob::findOrFail(decrypt($id));

        if ($cron->type == 'system') {
            notify()->error(__("You can't delete system cron job!"), 'Error');

            return redirect()->back();
        }

        $cron->delete();
        $cron->logs()->delete();

        notify()->success(__('Cron Job deleted successfully!'), 'Success');

        return redirect()->back();
    }

    public function runNow($id)
    {
        $cron = CronJob::find(decrypt($id));

        $response = $this->sendRequestToUrl(url($cron->url));

        if ($response['status'] == 'success') {
            notify()->success(__('Cron run successfully!'), 'Success');

            return back();
        }

        notify()->error(__('Cron run failed!'), 'Error');

        return back();

    }

    public function logs($id)
    {
        $logs = CronJobLog::where('cron_job_id', decrypt($id))->paginate();

        return view('backend.cron-jobs.logs', compact('logs', 'id'));
    }

    public function clearLogs($id)
    {
        CronJobLog::where('cron_job_id', decrypt($id))->delete();

        notify()->success(__('Cron logs cleared successfully!'), 'Success');

        return to_route('admin.cron.jobs.index');

    }

    protected function sendRequestToUrl($url)
    {
        try {

            Http::withOptions([
                'verify' => false,
            ])->get($url);

            return [
                'status' => 'success',
            ];

        } catch (\Throwable $th) {

            return [
                'status' => 'error',
            ];
        }
    }
}
