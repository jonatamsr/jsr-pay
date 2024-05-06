<?php

namespace App\Dtos;

class TransferDto
{
    public $payerId;
    public $payeeId;
    public $amount;

    public function __construct(int $payerId, int $payeeId, float $amount) {
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
        $this->amount = $amount;
    }
}
