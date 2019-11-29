<?php


namespace App\Helpers;


class Response
{
    public static function toJson($data = null, $message = 'ok', $status = true, $errorCode = 200) {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'result' => $data,
        ], $errorCode);
    }
}
