<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('permission:user-paybacks|bank-profit');
    }

    /**
     * @return Application|Factory|View|JsonResponse
     *
     * @throws Exception
     */
    public function userPaybacks(Request $request, $id = null)
    {
        $perPage = $request->perPage ?? 15;

        $status = $request->status ?? 'all';
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $profits = Transaction::with('user')
                            ->profit()
                            ->search($search)
                            ->status($status)
                            ->type($type)
                            ->when(in_array(request('sort_field'),['created_at','final_amount','type','description']),function($query){
                                $query->orderBy(request('sort_field'),request('sort_dir'));
                            })
                            ->when(request('sort_field') == 'user',function($query){
                                $query->whereHas('user',function($userQuery){
                                    $userQuery->orderBy('username',request('sort_dir'));
                                });
                            })
                            ->when(!request()->has('sort_field'),function($query){
                                $query->latest();
                            })
                            ->paginate($perPage)
                            ->withQueryString();

        $totalPaybacks = Transaction::with('user')
                            ->profit()
                            ->sum('amount');

        return view('backend.transaction.profit', compact('profits','totalPaybacks'));
    }

    public function bankProfit(Request $request)
    {
        $perPage = $request->integer('perPage') ?? 15;

        $status = $request->status ?? 'all';
        $search = $request->search ?? null;
        $type = $request->type ?? 'all';
        $profits = Transaction::with('user')
                        ->where('charge', '>', 0)
                        ->search($search)
                        ->status($status)
                        ->type($type)
                        ->when(in_array(request('sort_field'),['created_at','final_amount','type','description','username']),function($query){
                            $query->orderBy(request('sort_field'),request('sort_dir'));
                        })
                        ->when(request('sort_field') == 'user',function($query){
                            $query->whereHas('user',function($userQuery){
                                $userQuery->orderBy('username',request('sort_dir'));
                            });
                        })
                        ->when(!request()->has('sort_field'),function($query){
                            $query->latest();
                        })
                        ->paginate($perPage)
                        ->withQueryString();

        $totalProfits = Transaction::with('user')
                                ->where('charge', '>', 0)
                                ->sum('charge');

        return view('backend.transaction.bank-profit', compact('profits','totalProfits'));
    }
}
