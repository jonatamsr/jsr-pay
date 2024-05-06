<?php

namespace App\Ports\Outbound;
use App\Domain\Entities\Customer;

interface CustomerRepositoryPort
{
    public function createCustomer(Customer $customer): int;
    public function getCustomerByEmail(string $email): ?Customer;
    public function getCustomerByCpf(string $email): ?Customer;
    public function getCustomerByCnpj(string $email): ?Customer;
}
