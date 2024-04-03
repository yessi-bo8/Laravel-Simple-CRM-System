<?php

namespace App\Traits;

trait HTTPResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json(
        [
            'status'=> 'Request was successful.',
            'message' => $message,
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