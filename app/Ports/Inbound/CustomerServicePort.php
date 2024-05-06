<?php

namespace App\Ports\Inbound;

interface CustomerServicePort
{
    public function createCustomer(array $customerData): void;
}
