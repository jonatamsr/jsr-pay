<?php

namespace Tests\Unit\Domain\Services;

use App\Domain\Entities\Customer;
use App\Domain\Entities\Wallet;
use App\Domain\Services\ValidateTransferService;
use App\Exceptions\ValidationException;
use App\Models\CustomerType;
use Tests\TestCase;

class ValidateTransferServiceUnitTest extends TestCase
{
    public function testValidatePayerMustThrowExceptionWhenPayerIsNull(): void
    {
        $fakePayer = null;

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The informed payer customer does not exist');

        $validator = new ValidateTransferService();
        $validator->validatePayer($fakePayer);
    }

    public function testValidatePayerMustThrowExceptionWhenPayerCustomerTypeIsRetailer(): void
    {
        $fakePayer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_RETAILER,
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Retailer customers cannot make transfers');

        $validator = new ValidateTransferService();
        $validator->validatePayer($fakePayer);
    }

    public function testValidatePayerMustNotThrowAnyExceptionWhenValid(): void
    {
        $fakePayer = new Customer([
            'customer_type_id' => CustomerType::TYPE_ID_COMMON,
        ]);

        $this->expectNotToPerformAssertions();

        $validator = new ValidateTransferService();
        $validator->validatePayer($fakePayer);
    }

    public function testValidatePayeeMustThrowExceptionWhenPayerIsNull(): void
    {
        $fakePayee = null;

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The informed payee customer does not exist');

        $validator = new ValidateTransferService();
        $validator->validatePayee($fakePayee);
    }

    public function testValidatePayeeMustNotThrowAnyExceptionWhenValid(): void
    {
        $fakePayee = new Customer([
            'name' => 'fake-payee',
        ]);

        $this->expectNotToPerformAssertions();

        $validator = new ValidateTransferService();
        $validator->validatePayee($fakePayee);
    }

    public function testValidateAmountMustThrowValidationExceptionWhenAmountIsText(): void
    {
        $fakeAmount = 'fake-amount';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The amount field must be in decimal format (10,2)');

        $validator = new ValidateTransferService();
        $validator->validateAmount($fakeAmount);
    }

    public function testValidateAmountMustThrowValidationExceptionWhenAmountNotInCorrectDecimalFormat(): void
    {
        $fakeAmount = 10.123;

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The amount field must be in decimal format (10,2)');

        $validator = new ValidateTransferService();
        $validator->validateAmount($fakeAmount);
    }

    public function testValidateAmountMustNotThrowAnyExceptionWhenValid(): void
    {
        $fakeAmount = 10.12;

        $this->expectNotToPerformAssertions();

        $validator = new ValidateTransferService();
        $validator->validateAmount($fakeAmount);
    }

    public function testValidatePayerWalletMustThrowValidationExceptionWhenAmountBiggerThanBalance(): void
    {
        $fakeAmount = 10.123;
        $fakeWallet = new Wallet([
            'balance' => 5.00,
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Informed payer customer does not have that amount in balance');

        $validator = new ValidateTransferService();
        $validator->validatePayerWallet($fakeAmount, $fakeWallet);
    }

    public function testValidatePayerWalletMustNotThrowAnyExceptionWhenValid(): void
    {
        $fakeAmount = 10.123;
        $fakeWallet = new Wallet([
            'balance' => $fakeAmount,
        ]);

        $this->expectNotToPerformAssertions();

        $validator = new ValidateTransferService();
        $validator->validatePayerWallet($fakeAmount, $fakeWallet);
    }
}
