<?php

namespace App\Domain\Services;

use App\Domain\Entities\Customer;
use App\Domain\Entities\Wallet;
use App\Exceptions\ValidationException;
use App\Models\CustomerType;

class ValidateTransferService
{
    public function validatePayer(?Customer $payer): void
    {
        if (is_null($payer)) {
            throw new ValidationException('The informed payer customer does not exist');
        }

        $payerCustomerTypeId = $payer->getCustomerTypeId();
        if ($payerCustomerTypeId == CustomerType::TYPE_ID_RETAILER) {
            throw new ValidationException('Retailer customers cannot make transfers');
        }
    }

    public function validatePayee(?Customer $payee): void
    {
        if (is_null($payee)) {
            throw new ValidationException('The informed payee customer does not exist');
        }
    }

    public function validateAmount(float|string $amount): void
    {
        if (!preg_match('/^\d{1,8}(\.\d{0,2})?$/', $amount)) {
            throw new ValidationException('The amount field must be in decimal format (10,2)');
        }
    }

    public function validatePayerWallet(float $amount, Wallet $payerWallet): void
    {
        $walletBalance = $payerWallet->getBalance();
        if ($walletBalance < $amount) {
            throw new ValidationException('Informed payer customer does not have that amount in balance');
        }
    }
}
