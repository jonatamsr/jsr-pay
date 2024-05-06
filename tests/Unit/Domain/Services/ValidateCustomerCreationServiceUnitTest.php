<?php

namespace Tests\Unit\Domain\Services;

use App\Domain\Entities\Customer;
use App\Domain\Services\ValidateCustomerCreationService;
use Tests\TestCase;

class ValidateCustomerCreationServiceUnitTest extends TestCase
{
    public function testValidateIsCallingAllRules(): void
    {
        $fakeCustomer = new Customer([]);

        $partialMock = $this->createPartialMock(
            ValidateCustomerCreationService::class,
            [
                'validateCustomerTypeId',
                'validateName',
                'validateEmail',
                'validateCpf',
                'validateCnpj',
                'validatePassword',
            ]
        );
        $this->app->instance(ValidateCustomerCreationService::class, $partialMock);

        $partialMock->expects($this->once())
            ->method('validateCustomerTypeId')
            ->with($fakeCustomer);

        $partialMock->expects($this->once())
            ->method('validateName')
            ->with($fakeCustomer);

        $partialMock->expects($this->once())
            ->method('validateEmail')
            ->with($fakeCustomer);

        $partialMock->expects($this->once())
            ->method('validateCpf')
            ->with($fakeCustomer);

        $partialMock->expects($this->once())
            ->method('validateCnpj')
            ->with($fakeCustomer);

        $partialMock->expects($this->once())
            ->method('validatePassword')
            ->with($fakeCustomer);

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);

        $validator->validate($fakeCustomer);
    }

    //TODO: Create test for each rule from the validation class individually
}
