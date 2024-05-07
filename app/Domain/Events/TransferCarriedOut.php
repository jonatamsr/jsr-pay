<?php

namespace App\Domain\Events;

class TransferCarriedOut
{
    public function __construct(public int $payeeCustomerId)
    {
        $this->payeeCustomerId = $payeeCustomerId;
    }
}
