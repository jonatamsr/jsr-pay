<?php

namespace App\Domain\Services;

use App\Domain\Entities\Customer;
use App\Exceptions\ValidationException;
use App\Models\CustomerType;
use App\Ports\Outbound\CustomerRepositoryPort;
use Illuminate\Support\Str;

class ValidateCustomerCreationService
{
    private $customerRepository;

    public function __construct(CustomerRepositoryPort $customerRepository) {
        $this->customerRepository = $customerRepository;
    }

    public function validate(Customer $customer) {
        $this->validateCpf($customer);
        $this->validateCnpj($customer);
        $this->validateEmail($customer);
    }

    private function validateCpf(Customer $customer): void
    {
        $customerType = $customer->getType();
        if ($customerType !== CustomerType::TYPE_ID_COMMON) {
            return;
        }

        $cpf = $customer->getCpf();
        if (Str::length($cpf) !== 11) {
            throw new ValidationException('The CPF field must have 11 characters' . Str::length($cpf));
        }

        $existentCustomer = $this->customerRepository->getCustomerByCpf($cpf);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with CPF: ' . $cpf);
        }
    }

    private function validateCnpj(Customer $customer): void
    {
        $customerType = $customer->getType();
        if ($customerType !== CustomerType::TYPE_ID_RETAILER) {
            return;
        }

        $cnpj = $customer->getCnpj();
        if (Str::length($cnpj) <> 14) {
            throw new ValidationException('The CNPJ field must have 14 characters');
        }

        $existentCustomer = $this->customerRepository->getCustomerByCnpj($cnpj);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with CNPJ: ' . $cnpj);
        }
    }

    private function validateEmail(Customer $customer): void
    {
        $email = $customer->getEmail();
        if (!Str::containsAll($email, ['@', '.'])) {
            throw new ValidationException('The email field must be correctly formatted');
        }

        $existentCustomer = $this->customerRepository->getCustomerByEmail($email);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with email: ' . $email);
        }
    }
}
