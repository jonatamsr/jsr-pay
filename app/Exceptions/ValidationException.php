<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json(['validation-error' => $this->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}