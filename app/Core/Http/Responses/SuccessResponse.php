<?php

namespace App\Core\Http\Responses;

use Illuminate\Http\Response;

class SuccessResponse
{
    public static function json($data = null, $headers = array()): Response
    {
        $successData = ['success'=>'success'];
        if (!is_null($data)) {
            $successData = array_merge($successData, $data);
        }
        return response()->json($successData, 200);
    }
}
