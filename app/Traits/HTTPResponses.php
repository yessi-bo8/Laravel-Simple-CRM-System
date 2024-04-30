<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait HTTPResponses
{
    /**
     * Return a success response.
     *
     * @param mixed $data The data to be returned in the response.
     * @param string|null $message The message describing the success. If null, the default message based on HTTP status code is used.
     * @param int $code The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the success message, data, and status code.
     */
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

      /**
     * Return an error response.
     *
     * @param mixed $data The data to be returned in the response.
     * @param string|null $message The message describing the error. If null, the default message based on HTTP status code is used.
     * @param int $code The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the error message, data, and status code.
     */
    protected function error($data, $message = null, $code)
    {
        $statusText = Response::$statusTexts[$code] ?? 'Unknown Status';
        return response()->json(
        [
            'status'=> 'Request was not successful.',
            'error' => $message ?? $statusText,
            'data' => $data
        ], $code
        );
    }



}