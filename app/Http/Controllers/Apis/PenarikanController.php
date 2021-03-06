<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Penarikan;
use App\Models\Transaction;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Yajra\DataTables\DataTables;

class PenarikanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['invoice']]);
    }

    public function invoice(Request $request, $id) {
        $detail = Penarikan::where('id_penarikan', $id)->with('user')->first();

        $pdf = PDF::loadView('invoice', ['data'=> $detail])->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream();
    }

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
        $p->user_id = $user['id_user'];
        $p->saldo = $user['pendapatan'];
        $p->penarikan = intval($request->jumlah);
        $p->save();

        if ($p) {
            $transaction = new Transaction();
            $transaction->user_id = $p->user_id;
            $transaction->ip = $request->server('SERVER_ADDR');
            $transaction->total_belanja = $p->saldo;
            $transaction->komisi = '-'.$request->jumlah;
            $transaction->cookie = 'sistem';
            $transaction->save();
        }

        return Response::toJson($p);
    }

    public function detail($id)
    {
        $penarikan = Penarikan::select('penarikans.*', 'users.name', 'blogs.url_blog')
            ->leftJoin('users', 'penarikans.user_id', '=', 'users.id_user')
            ->leftJoin('blogs', 'penarikans.user_id', '=', 'blogs.id_user')
            ->where('penarikans.id_penarikan', $id)->first();

        return Response::toJson($penarikan);
    }

    public function all(Request $request)
    {
        $penarikan = Penarikan::select('penarikans.*', 'users.name')->leftJoin('users', 'penarikans.user_id', '=', 'users.id_user');
        return DataTables::of($penarikan)->make(true);
    }

    public function change_status(Request $request, $id)
    {
        $penarikan = Penarikan::where('id_penarikan', $id)->first();
        $penarikan->status = $request->status;
        $penarikan->save();

        if (!$penarikan) {
            return Response::toJson(null, 'Penarikan tidak ditemukan', false);
        }

        return Response::toJson($penarikan);

    }
}
