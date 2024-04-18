<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HTTPResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        $statusText = Response::$statusTexts[$code] ?? 'Unknown Status';
        return response()->json(
        [
            'status'=> 'Request was successful.',
            'message' => $message ?? $statusText,
            'data' => $data
        ], $code
        );
    }

    protected function error($data, $message = null, $code)
    {
        return response()->json(
        [
            'status'=> 'Request was not successful.',
            'message' => $message,
            'data' => $data
        ], $code
        );
    }



}