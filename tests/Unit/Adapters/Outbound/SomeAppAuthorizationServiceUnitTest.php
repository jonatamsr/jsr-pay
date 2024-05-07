<?php

namespace Tests\Unit\Adapters\Outbound;

use App\Adapters\Outbound\SomeAppAuthorizationService;
use App\Exceptions\AuthorizationException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SomeAppAuthorizationServiceUnitTest extends TestCase
{
    public function testSomeAppAuthorizationServiceMustThrowAuthorizationServiceWhenAuthenticationFails(): void
    {
        Http::fake([
            'auth/auth-mock'=> Http::response(['message' => 'Não Autorizado!', Response::HTTP_UNAUTHORIZED])
        ]);

        /** @var SomeAppAuthorizationService $test */
        $test = app(SomeAppAuthorizationService::class);

        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('Unauthorized!');

        $test->authorize();
    }
}
