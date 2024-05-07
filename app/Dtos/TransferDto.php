<?php

namespace App\Dtos;

class TransferDto
{
    public function __construct(
        public int $payerId,
        public int $payeeId,
        public float $amount
    ) {
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
        $this->amount = $amount;
    }
}
