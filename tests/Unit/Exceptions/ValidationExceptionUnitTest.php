<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ValidationException;
use Tests\TestCase;

class ValidationExceptionUnitTest extends TestCase
{
    public function testValidationExceptionMustRenderExceptionCorrectly(): void
    {
        $fakeValidationException = new ValidationException('fake-message');

        $response = $fakeValidationException->render();

        $this->assertEquals('fake-message', $response->getData(true)['validation-error']);
    }
}
