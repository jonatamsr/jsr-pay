<?php

namespace App\Ports\Outbound;
use App\Domain\Entities\Customer;

interface CustomerRepositoryPort
{
    public function createCustomer(Customer $customer): int;
}
