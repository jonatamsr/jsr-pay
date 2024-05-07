<?php

namespace App\Domain\Events;

class CustomerCreated
{
    public function __construct(public int $customerId)
    {
        $this->customerId = $customerId;
    }
}
