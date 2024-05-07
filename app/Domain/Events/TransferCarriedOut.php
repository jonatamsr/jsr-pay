<?php

namespace App\Domain\Events;

class TransferCarriedOut
{
    public $payeeCustomerId;

    public function __construct(int $payeeCustomerId)
    {
        $this->payeeCustomerId = $payeeCustomerId;
    }
}
