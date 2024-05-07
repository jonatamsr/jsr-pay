<?php

namespace App\Domain\Events;

class CustomerCreated
{
    public $customerId;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }
}
