<?php

namespace Tests\Unit\Exceptions;

use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Tests\TestCase;

class ValidationExceptionUnitTest extends TestCase
{
    public function testCustomerCreatedInstanceMustFillCustomerId(): void
    {
        $fakeValidationException = new ValidationException('fake-message');

        $fakeRequest = new Request();

        $response = $fakeValidationException->render($fakeRequest);

        $this->assertEquals('fake-message', $response->getData(true)['validation-error']);
    }
}
