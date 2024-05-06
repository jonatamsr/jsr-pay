<?php

namespace App\Ports\Inbound;

interface TransactionServicePort
{
    public function transfer(array $transferData): void;
}
