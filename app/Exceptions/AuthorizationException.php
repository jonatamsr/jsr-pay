<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['authorization-error' => $this->getMessage()], Response::HTTP_UNAUTHORIZED);
    }
}