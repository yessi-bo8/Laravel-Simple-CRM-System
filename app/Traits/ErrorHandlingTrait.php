<?php

namespace App\Traits;
use App\Traits\HTTPResponses;
use app\Exceptions\ModelNotChangedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait ErrorHandlingTrait
{
    use HTTPResponses;


    private function handleError($exception, $message, $statusCode)
    {
        DB::rollBack();
        Log::error('Error occurred: ' . $exception->getMessage());

        // Check if the request URL contains '/api/'
        if (str_contains(Request::url(), '/api/')) {
            // If the request is from an API, return response as JSON
            return $this->error(null, $message, $statusCode);
        } else {
            // If it's a web request, redirect back with error message
            return redirect()->back()->with(['error' => $message, 'statusCode' => $statusCode]);
        }
    }


    public function handleExceptions($e, $model, $method)
    {
        if ($e instanceof ModelNotFoundException) {
            $message = $model . " not found.";
            $statusCode = 404;
        } elseif ($e instanceof AuthorizationException) {
            $message = "No Authorization to " . $method . " " . $model . ".";
            $statusCode = 403;
        } elseif ($e instanceof ModelNotChangedException) {
            $message = "No changes were made to " . $model . ". Please make changes to update.";
            $statusCode = 422;
        } else {
            $message = "Failed to " . $method . " " . $model . ".";
            $statusCode = 500;
        }

        return $this->handleError($e, $message, $statusCode);
    }
}
