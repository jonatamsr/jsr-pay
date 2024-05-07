<?php

namespace App\Ports\Outbound;

use App\Dtos\TransferDto;

interface TransactionRepositoryPort
{
    public function createTransaction(TransferDto $transferDto): int;
    public function updateTransactionStatus(int $transactionId, int $statusId): void;
}
