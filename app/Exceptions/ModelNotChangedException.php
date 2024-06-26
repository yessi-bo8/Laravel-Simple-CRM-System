<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModelNotChangedException extends Exception
{
    /**
     * Constructor to initialize the exception instance.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "No changes were made to the Model", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode());
    }
}
