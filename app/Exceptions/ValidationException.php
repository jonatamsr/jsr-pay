<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends Exception
{
    protected $errors;

    public function __construct($message = "", $code = 0, $errors = [])
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function render($request): JsonResponse
    {
        return response()->json(['validation-error' => $this->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}