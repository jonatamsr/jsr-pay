<?php

namespace App\Application\Services;

use App\Ports\Outbound\WalletRepositoryPort;

class WalletService
{
    public function __construct(private WalletRepositoryPort $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function createWallet(int $customerId): int
    {
        return $this->walletRepository->createWallet($customerId);
    }
}
