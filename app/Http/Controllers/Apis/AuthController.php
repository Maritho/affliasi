<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\Response;
use App\Models\Bank;
use App\Models\Blog;
use App\Models\BloggerViewSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;
use Yajra\DataTables\DataTables;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        $credentials['status'] = 1;

        if (! $token = auth('api')->attempt($credentials)) {
            return Response::toJson(null, 'Email atau password yang anda masukkan salah', false, 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'url_blog' => 'required|url',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return Response::toJson(null, Str::ucfirst($validator->errors()->first()), false);
        }

        $user = new User;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $blog = new Blog();
        $blog->id_user = $user->id_user;
        $blog->url_blog = $request->url_blog;
        $blog->save();

        return Response::toJson($user);
    }

    public function me()
    {
        return Response::toJson(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return Response::toJson(null, 'Successfully logged out');
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function rekening(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rekening_name' => 'required',
            'rekening_number' => 'required',
            'rekening_bank' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::toJson(null, Str::ucfirst($validator->errors()->first()), false);
        }

        $user_id = Auth::user($request, true);

        $user = Bank::where('id_user', $user_id)->first();
        if ($user == null) {
            $user = new Bank();
            $user->id_user = $user_id;
            $user->bank_name = $request->rekening_name;
            $user->bank_rekening = $request->rekening_number;
            $user->bank = $request->rekening_bank;
            $user->save();
        } else {
            $user->bank_name = $request->rekening_name;
            $user->bank_rekening = $request->rekening_number;
            $user->bank = $request->rekening_bank;
            $user->save();
        }


        return Response::toJson($user);
    }

    public function blogger(Request $request)
    {
        $blogger = DB::select('SELECT id_user, name, url_blog, status, total_pendapatan, total_klik
        FROM affliasi.blogger_view_summary;
        ');
        return DataTables::of($blogger)->make(true);
    }

    public function blogger_delete($id) {

        User::where('id_user', $id)->delete();
        return Response::toJson();

    }

    public function change_status($id)
    {
        $user = User::where('id_user', $id)->first();

        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }

        $user->save();

        return Response::toJson($user);
    }

    protected function respondWithToken($token)
    {
        $data = [
            'token' => $token,
            'type' => 'bearer',
            'expires' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ];

        return Response::toJson($data);

    }
}
