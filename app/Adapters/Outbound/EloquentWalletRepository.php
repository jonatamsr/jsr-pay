<?php

namespace App\Adapters\Outbound;
use App\Models\Wallet as WalletEloquentModel;
use App\Ports\Outbound\WalletRepositoryPort;

class EloquentWalletRepository implements WalletRepositoryPort
{
    private const INITIAL_BALANCE = 0;

    public function createWallet(int $customerId): int
    {
        $createdWallet = WalletEloquentModel::create([
            'customer_id' => $customerId,
            'balance' => self::INITIAL_BALANCE,
        ]);

        return $createdWallet->id;
    }
}
