<?php

namespace App\Adapters\Outbound;

use App\Exceptions\AuthorizationException;
use App\Ports\Outbound\AuthorizationServicePort;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SomeAppAuthorizationService implements AuthorizationServicePort
{
    public function authorize(): void
    {
        Http::fake([
            'auth/auth-mock' => Http::response(['message' => 'Autorizado'], Response::HTTP_OK),
        ]);

        $response = json_decode(
            Http::post('auth/auth-mock')->getBody()->getContents(),
            true
        );

        if ($response['message'] !== 'Autorizado') {
            throw new AuthorizationException('Unauthorized!');
        }
    }
}
