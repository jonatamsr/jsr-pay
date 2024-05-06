<?php

namespace App\Application\Services;
use App\Domain\Entities\Customer;
use App\Domain\Events\CustomerCreated;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use Illuminate\Events\Dispatcher;

class CustomerService implements CustomerServicePort
{
    private $customerRepository;
    private $eventDispatcher;

    public function __construct(CustomerRepositoryPort $customerRepository, Dispatcher $eventDispatcher) {
        $this->customerRepository = $customerRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createCustomer(array $customerData): void
    {
        $customer = new Customer($customerData);
        $passwordHash = hash('sha256', $customerData['password']);
        $customer->setPassword($passwordHash);

        $customerId = $this->customerRepository->createCustomer($customer);

        $this->eventDispatcher->dispatch(new CustomerCreated($customerId));
    }
}
