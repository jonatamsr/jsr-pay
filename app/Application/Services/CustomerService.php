<?php

namespace App\Application\Services;
use App\Domain\Entities\Customer;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Outbound\customerRepositoryPort;

class CustomerService implements CustomerServicePort
{
    private $customerRepository;

    public function __construct(customerRepositoryPort $customerRepository) {
        $this->customerRepository = $customerRepository;
    }

    public function createCustomer(array $customerData): void {
        $customer = new Customer($customerData);
        $passwordHash = hash('sha256', $customerData['password']);
        $customer->setPassword($passwordHash);

        $this->customerRepository->createCustomer($customer);
    }
}
