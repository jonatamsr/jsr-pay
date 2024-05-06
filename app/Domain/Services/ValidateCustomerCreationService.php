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
        $this->validateCustomerTypeId($customer);
        $this->validateName($customer);
        $this->validateEmail($customer);
        $this->validateCpf($customer);
        $this->validateCnpj($customer);
        $this->validatePassword($customer);
    }

    private function validateCustomerTypeId(Customer $customer): void
    {
        $customerTypeId = $customer->getCustomerTypeId();
        
        if (empty($customerTypeId)) {
            throw new ValidationException('The customer_type_id field is required');
        }

        if (!in_array($customerTypeId, [1, 2])) {
            throw new ValidationException('The customer_type_id field must be 1 (common) or 2 (retailer)');
        }
    }

    private function validateName(Customer $customer): void
    {
        $name = $customer->getName();
        
        if (empty($name)) {
            throw new ValidationException('The name field is required');
        }

        if (Str::length($name) < 3) {
            throw new ValidationException('The name field must have at least 3 characters');
        }

        if (Str::length($name) > 100) {
            throw new ValidationException('The name field cannot surpass 100 characters');
        }
    }

    private function validateEmail(Customer $customer): void
    {
        $email = $customer->getEmail();
        if (empty($email)) {
            throw new ValidationException('The email field is required');
        }

        if (!Str::containsAll($email, ['@', '.'])) {
            throw new ValidationException('The email field must be correctly formatted');
        }

        if (Str::length($email) > 100) {
            throw new ValidationException('The email field cannot surpass 100 characters');
        }

        $existentCustomer = $this->customerRepository->getCustomerByEmail($email);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with email: ' . $email);
        }
    }

    private function validateCpf(Customer $customer): void
    {
        $customerType = $customer->getType();
        $cpf = $customer->getCpf();
        if ($customerType !== CustomerType::TYPE_ID_COMMON && !empty($cpf)) {
            throw new ValidationException('A retailer customer must not have cpf informed');
        }

        if ($customerType !== CustomerType::TYPE_ID_COMMON) {
            return;
        }

        if (empty($cpf)) {
            throw new ValidationException('The CPF field is required');
        }

        if (Str::length($cpf) !== 11) {
            throw new ValidationException('The CPF field must have 11 characters');
        }

        $existentCustomer = $this->customerRepository->getCustomerByCpf($cpf);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with CPF: ' . $cpf);
        }
    }

    private function validateCnpj(Customer $customer): void
    {
        $customerType = $customer->getType();
        $cnpj = $customer->getCnpj();
        if ($customerType !== CustomerType::TYPE_ID_RETAILER && !empty($cnpj)) {
            throw new ValidationException('A common customer must not have cnpj informed');
        }

        if ($customerType !== CustomerType::TYPE_ID_RETAILER) {
            return;
        }

        if (empty($cnpj)) {
            throw new ValidationException('The CNPJ field is required');
        }

        if (Str::length($cnpj) <> 14) {
            throw new ValidationException('The CNPJ field must have 14 characters');
        }

        $existentCustomer = $this->customerRepository->getCustomerByCnpj($cnpj);
        if (!is_null($existentCustomer)) {
            throw new ValidationException('Customer already exists with CNPJ: ' . $cnpj);
        }
    }

    private function validatePassword(Customer $customer): void
    {
        $password = $customer->getPassword();

        if (empty($password)) {
            throw new ValidationException('The password field is required');
        }

        if (Str::length($password) < 8) {
            throw new ValidationException('The password field must have at least 8 characters');
        }
    }
}
