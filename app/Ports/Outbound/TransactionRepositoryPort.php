<?php

namespace App\Ports\Outbound;

use App\Dtos\TransferDto;

interface TransactionRepositoryPort
{
    public function createTransaction(TransferDto $transferDto): string;
    public function updateTransactionStatus(string $transactionId, int $statusId): void;
}
