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

    /**
     * Handle errors and exceptions, including rolling back any active database transactions.
     *
     * @param  \Exception $exception The exception object.
     * @param  string $message The error message.
     * @param  int $statusCode The HTTP status code.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse The response based on request type.
     */
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


    /**
     * Handle exceptions and return appropriate response.
     *
     * @param  \Exception $e The exception object.
     * @param  string $model The model name.
     * @param  string $method The method name.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse The response based on exception type.
     */
    public function handleExceptions($e, $model, $method)
    {
        if ($e instanceof ModelNotFoundException) {
            $message = $model . " not found.";
            $statusCode = 404;
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
