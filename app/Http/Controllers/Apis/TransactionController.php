<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['tracking', 'callback']]);
    }

    public function getTansaction(Request $request)
    {
        $user = Auth::user($request);
        $user_id = null;
        if ($user->role == 'affliate') {
            $user_id = $user->id_user;
        }

        $transaction = Transaction::when($user_id, function ($query, $user_id) {
            $query->where('user_id', $user_id);
            $query->where('status', 1);
        });

        return DataTables::of($transaction)->make(true);
    }

    /**
     * @param Request $request
     * affliate_id
     * campaign_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tracking(Request $request)
    {
        $affliate_id = $request->query('affliate_id');
        $campaign_id = $request->query('campaign_id');

        $campaign = Campaign::where('id_campaign', $campaign_id)->first();

        $transaction = new Transaction();
        $transaction->user_id = $affliate_id;
        $transaction->ip = $request->ip();
        $transaction->id_campaign = $campaign->id_campaign;
        $transaction->total_belanja = 0;
        $transaction->komisi = 0;
        $transaction->cookie = 'active';
        $transaction->status = 1;
        $transaction->save();

        $redirect = $campaign->landing_page .'?type=affliasi&transaction_id='.$transaction->id_transaction.'&campaign='.$campaign->campaign_name;
        return Redirect::to($redirect);
    }

    /**
     * @param Request $request
     * transaction_id: int
     * campaign: string
     * total: int
     * komisi: int
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        $transaction = Transaction::where('id_transaction', $request->transaction_id)->first();
        $transaction->total_belanja = $request->total;
        $transaction->komisi = $request->komisi;
        $transaction->cookie = 'inactive';
        $transaction->save();

        return Response::toJson($transaction);
    }
}
