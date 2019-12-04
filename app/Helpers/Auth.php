<?php


namespace App\Helpers;


class Auth
{
    public static function user($request, $user_id = false) {

        $user = auth('api')->user();

        if ($user_id) {
            return $user->id;
        }

        return $user;
    }
}
