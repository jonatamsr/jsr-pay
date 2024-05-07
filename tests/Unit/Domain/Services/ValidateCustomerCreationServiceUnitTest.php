<?php

namespace Tests\Unit\Domain\Services;

use App\Domain\Entities\Customer;
use App\Domain\Services\ValidateCustomerCreationService;
use App\Exceptions\ValidationException;
use App\Models\CustomerType;
use App\Ports\Outbound\CustomerRepositoryPort;
use Tests\TestCase;

class ValidateCustomerCreationServiceUnitTest extends TestCase
{
    private $customerRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerRepositoryMock = $this->createMock(CustomerRepositoryPort::class);
        $this->app->instance(CustomerRepositoryPort::class, $this->customerRepositoryMock);
    }

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

    public function testValidateCustomerTypeIdMustThrowExceptionWhenNull(): void
    {
        $fakeCustomer = new Customer([]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The customer_type_id field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCustomerTypeId',
            [$fakeCustomer]
        );
    }

    public function testValidateCustomerTypeIdMustThrowExceptionWhenIdOutOfRange(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => 3,
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The customer_type_id field must be 1 (common) or 2 (retailer)');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCustomerTypeId',
            [$fakeCustomer]
        );
    }

    public function testValidateCustomerTypeIdMustNotThrowAnyExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => 1,
        ]);

        $this->expectNotToPerformAssertions();

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCustomerTypeId',
            [$fakeCustomer]
        );
    }

    public function testValidateNameMustThrowValidationExceptionWhenNull(): void
    {
        $fakeCustomer = new Customer([]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateName',
            [$fakeCustomer]
        );
    }

    public function testValidateNameMustThrowValidationExceptionWhenHasLessThanThreeCharacters(): void
    {
        $fakeCustomer = new Customer([
            'name' => 'fk',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field must have at least 3 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateName',
            [$fakeCustomer]
        );
    }

    public function testValidateNameMustThrowValidationExceptionWhenHasMoreThanOneHundredCharacters(): void
    {
        $fakeCustomer = new Customer([
            'name' => str_repeat('a', 101),
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field cannot surpass 100 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateName',
            [$fakeCustomer]
        );
    }

    public function testValidateNameMustNotThrowAnyExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'name' => 'Fake Customer',
        ]);

        $this->expectNotToPerformAssertions();

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateName',
            [$fakeCustomer]
        );
    }

    public function testValidateEmailMustThrowValidationExceptionWhenNull(): void
    {
        $fakeCustomer = new Customer([]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateEmail',
            [$fakeCustomer]
        );
    }

    public function testValidateEmailMustThrowValidationExceptionWhenNotEmailFormatted(): void
    {
        $fakeCustomer = new Customer([
            'email' => 'fakeemail',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field must be correctly formatted');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateEmail',
            [$fakeCustomer]
        );
    }

    public function testValidateEmailMustThrowValidationExceptionWhenHasMoreThanOneHundredCharacters(): void
    {
        $fakeCustomer = new Customer([
            'email' => str_repeat('fake@email.com', 101),
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field cannot surpass 100 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateEmail',
            [$fakeCustomer]
        );
    }

    public function testValidateEmailMustThrowValidationExceptionWhenHasOtherCustomerWithSameEmail(): void
    {
        $fakeCustomer = new Customer([
            'email' => 'fake@email.com',
        ]);

        $expectedRepositoryResponseCustomer = new Customer([
            'email' => 'fake@email.com',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByEmail')
            ->willReturn($expectedRepositoryResponseCustomer);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Customer already exists with email: fake@email.com');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateEmail',
            [$fakeCustomer]
        );
    }

    public function testValidateEmailMustNotThrowAnyValidationExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'email' => 'fake@email.com',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByEmail')
            ->willReturn(null);

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateEmail',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustThrowValidationExceptionWhenRetailerWithCpfInformed(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cpf' => 'fake-cpf',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('A retailer customer must not have cpf informed');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustNotThrowAnyValidationExceptionWhenRetailerWithouCpfInformed(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cpf' => null,
        ]);

        $this->expectNotToPerformAssertions();

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustThrowValidationExceptionWhenCommonAndCpfEmpty(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => null,
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CPF field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustThrowValidationExceptionWhenCpfLessThanElevenDigits(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '1234567890',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CPF field must have 11 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustThrowValidationExceptionWhenCpfMoreThanElevenDigits(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '123456789012',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CPF field must have 11 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustThrowValidationExceptionWhenTheresAnotherCustomerWithSameCpf(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '12345678901',
        ]);

        $existentCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '12345678901',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByCpf')
            ->willReturn($existentCustomer);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Customer already exists with CPF: 12345678901');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCpfMustNotThrowAnyValidationExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cpf' => '12345678901',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByCpf')
            ->willReturn(null);

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCpf',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustThrowValidationExceptionWhenCommonCustomerWithCnpjInformed(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cnpj' => 'fake-cnpj',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('A common customer must not have cnpj informed');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustNotThrowAnyValidationExceptionWhenCommonCustomerWithouCnpjInformed(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
            'cnpj' => null,
        ]);

        $this->expectNotToPerformAssertions();

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustThrowValidationExceptionWhenRetailerAndCnpjEmpty(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => null,
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CNPJ field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustThrowValidationExceptionWhenCnpjLessThanFourteenDigits(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => '1234567890123',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CNPJ field must have 14 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustThrowValidationExceptionWhenCnpjMoreThanFourteenDigits(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => '123456789012345',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The CNPJ field must have 14 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustThrowValidationExceptionWhenTheresAnotherCustomerWithSameCnpjs(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => '12345678901234',
        ]);

        $existentCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => '12345678901234',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByCnpj')
            ->willReturn($existentCustomer);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Customer already exists with CNPJ: 12345678901234');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidateCnpjMustNotThrowAnyValidationExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
            'cnpj' => '12345678901234',
        ]);

        $this->customerRepositoryMock->expects($this->once())
            ->method('getCustomerByCnpj')
            ->willReturn(null);

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validateCnpj',
            [$fakeCustomer]
        );
    }

    public function testValidatePasswordMustThrowValidationExceptionWhenEmpty(): void
    {
        $fakeCustomer = new Customer([]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The password field is required');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validatePassword',
            [$fakeCustomer]
        );
    }

    public function testValidatePasswordMustThrowValidationExceptionWhenPasswordHasLessThanEightCharacters(): void
    {
        $fakeCustomer = new Customer([
            'password' => '1234567',
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The password field must have at least 8 characters');

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validatePassword',
            [$fakeCustomer]
        );
    }

    public function testValidatePasswordMustNotThrowAnyValidationExceptionWhenDataIsValid(): void
    {
        $fakeCustomer = new Customer([
            'password' => '12345678',
        ]);

        $this->expectNotToPerformAssertions();

        /** @var ValidateCustomerCreationService $validator */
        $validator = app(ValidateCustomerCreationService::class);
        $this->invokeNonPublicMethod(
            $validator,
            'validatePassword',
            [$fakeCustomer]
        );
    }
}
