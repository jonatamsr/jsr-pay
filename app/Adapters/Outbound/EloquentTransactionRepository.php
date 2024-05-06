<?php

namespace App\Adapters\Outbound;

use App\Dtos\TransferDto;
use App\Models\Transaction as TransactionEloquentModel;
use App\Models\TransactionStatus;
use App\Ports\Outbound\TransactionRepositoryPort;

class EloquentTransactionRepository extends Repository implements TransactionRepositoryPort
{
    public function createTransaction(TransferDto $transferDto): int
    {
        $transaction = TransactionEloquentModel::query()
            ->create([
                'payer_id' => $transferDto->payerId,
                'payee_id' => $transferDto->payeeId,
                'amount' => $transferDto->amount,
                'transaction_status_id' => TransactionStatus::STATUS_ID_PROCESSING,
            ]);

        return $transaction->id;
    }

    public function updateTransactionStatus(int $transactionId, int $statusId): void
    {
        TransactionEloquentModel::query()
            ->where('id', $transactionId)->update(['transaction_status_id'=> $statusId]);
    }
}
