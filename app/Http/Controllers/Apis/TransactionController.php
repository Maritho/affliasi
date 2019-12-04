<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function getTansaction(Request $request)
    {
        $user = Auth::user($request);
        $user_id = null;
        if ($user->role == 'affliate') {
            $user_id = $user->id;
        }

        $transaction = Transaction::when($user_id, function ($query, $user_id) {
            $query->where('user_id', $user_id);
            $query->where('status', 1);
        });

        return DataTables::of($transaction)->make(true);
    }
}
