<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Penarikan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Yajra\DataTables\DataTables;

class PenarikanController extends Controller
{
    public function penarikan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::toJson(null, Str::ucfirst($validator->errors()->first()), false);
        }

        $user = Auth::user($request)->toArray();

        if (intval($request->jumlah) > $user['pendapatan']) {
            return Response::toJson(null, 'Maaf pendapatan anda belum mencukupi untuk penarikan sebesar Rp. '.number_format($request->jumlah), false);
        }

        $p = new Penarikan();
        $p->user_id = $user['id'];
        $p->saldo = $user['pendapatan'];
        $p->penarikan = intval($request->jumlah);
        $p->save();

        if ($p) {
            $transaction = new Transaction();
            $transaction->user_id = $p->user_id;
            $transaction->ip = $request->server('SERVER_ADDR');
            $transaction->total = $p->saldo;
            $transaction->commision = '-'.$request->jumlah;
            $transaction->cookie = 'sistem';
            $transaction->save();
        }

        return Response::toJson($p);
    }

    public function detail($id)
    {
        $penarikan = Penarikan::select('penarikans.*', 'users.name', 'users.url_blog')->leftJoin('users', 'penarikans.user_id', '=', 'users.id')
            ->where('penarikans.id', $id)->first();
        return Response::toJson($penarikan);
    }

    public function all(Request $request)
    {
        $penarikan = Penarikan::select('penarikans.*', 'users.name')->leftJoin('users', 'penarikans.user_id', '=', 'users.id');
        return DataTables::of($penarikan)->make(true);
    }

    public function change_status(Request $request, $id)
    {
        $penarikan = Penarikan::where('id', $id)->first();
        $penarikan->status = $request->status;
        $penarikan->save();

        if (!$penarikan) {
            return Response::toJson(null, 'Penarikan tidak ditemukan', false);
        }

        return Response::toJson($penarikan);

    }
}
