<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class HttpResponse
{
    public static function success($data, $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'detail'  => $data
        ]);
    }

    public static function error($status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'success' => false,
            'detail'  => ''
        ], $status);
    }
}
