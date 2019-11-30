<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Helpers\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

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
        $user->url_blog = $request->url_blog;
        $user->save();

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
