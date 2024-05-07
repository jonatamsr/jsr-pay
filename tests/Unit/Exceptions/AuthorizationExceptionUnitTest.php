<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\AuthorizationException;
use Tests\TestCase;

class AuthorizationExceptionUnitTest extends TestCase
{
    public function testAuthorizationExceptionMustRenderExceptionCorrectly(): void
    {
        $fakeValidationException = new AuthorizationException('fake-message');

        $response = $fakeValidationException->render();

        $this->assertEquals('fake-message', $response->getData(true)['authorization-error']);
    }
}
