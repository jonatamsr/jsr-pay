<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ValidationException;
use Tests\TestCase;

class AuthorizationExceptionUnitTest extends TestCase
{
    public function testAuthorizationExceptionMustRenderExceptionCorrectly(): void
    {
        $fakeValidationException = new ValidationException('fake-message');

        $response = $fakeValidationException->render();

        $this->assertEquals('fake-message', $response->getData(true)['validation-error']);
    }
}
