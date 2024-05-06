<?php

namespace App\Ports\Outbound;
use App\Domain\Entities\Customer;

interface customerRepositoryPort
{
    public function createCustomer(Customer $customer): void;
}
