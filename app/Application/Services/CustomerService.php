<?php

namespace App\Application\Services;

use App\Domain\Entities\Customer;
use App\Domain\Events\CustomerCreated;
use App\Domain\Services\ValidateCustomerCreationService;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use Illuminate\Events\Dispatcher;

class CustomerService implements CustomerServicePort
{
    public function __construct(
        private CustomerRepositoryPort $customerRepository,
        private ValidateCustomerCreationService $customerValidator,
        private Dispatcher $eventDispatcher
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerValidator = $customerValidator;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createCustomer(array $customerData): void
    {
        $customer = new Customer($customerData);

        $this->customerValidator->validate($customer);

        $passwordHash = hash('sha256', $customerData['password']);
        $customer->setPassword($passwordHash);

        $customerId = $this->customerRepository->createCustomer($customer);

        $this->eventDispatcher->dispatch(new CustomerCreated($customerId));
    }
}
