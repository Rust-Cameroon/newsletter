<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use ImageUpload, NotifyTrait;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:support-ticket-list|support-ticket-action', ['only' => ['index']]);
        $this->middleware('permission:support-ticket-action', ['only' => ['closeNow', 'reply', 'show']]);

    }

    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 15;
        $search = $request->search ?? null;
        $status = $request->status ?? 'all';
        $tickets = Ticket::search($search)
                        ->status($status)
                        ->when(request('query') != null,function($query){
                            $query->where('title','LIKE','%'.request('query').'%');
                        })
                        ->when(in_array(request('sort_field'),['created_at','title','status']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate($perPage);

        return view('backend.ticket.index', compact('tickets'));
    }

    public function show($uuid)
    {
        $ticket = Ticket::uuid($uuid);

        return view('backend.ticket.show', compact('ticket'));
    }

    public function closeNow($uuid)
    {
        Ticket::uuid($uuid)->close();
        notify()->success('Ticket Closed successfully', 'success');

        return Redirect::route('admin.ticket.index');

    }

    public function reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $adminId = \Auth::id();

        $attachments = [];

        foreach ($request->file('attachments', []) as $attach) {
            $attachments[] = self::imageUploadTrait($attach);
        }

        $data = [
            'model' => 'admin',
            'user_id' => $adminId,
            'message' => nl2br($input['message']),
            'attachments' => json_encode($attachments),
        ];

        $ticket = Ticket::uuid($input['uuid']);

        $ticket->messages()->create($data);

        $shortcodes = [
            '[[full_name]]' => $ticket->user->full_name,
            '[[email]]' => $ticket->user->email,
            '[[subject]]' => $input['uuid'],
            '[[title]]' => $ticket->title,
            '[[message]]' => $data['message'],
            '[[status]]' => $ticket->status,
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
        ];

        $this->mailNotify($ticket->user->email, 'user_support_ticket', $shortcodes);
        $this->pushNotify('support_ticket_reply', $shortcodes, route('user.ticket.show', $ticket->uuid), $ticket->user_id);

        notify()->success(__('Ticket Reply successfully'), 'success');

        return Redirect::route('admin.ticket.show', $ticket->uuid);

    }
}
