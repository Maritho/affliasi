<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Helpers\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return Response::toJson(null, 'Unauthorized', false, 401);
        }

        return $this->respondWithToken($token);
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
