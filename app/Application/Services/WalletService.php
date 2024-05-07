<?php

namespace App\Application\Services;

use App\Ports\Outbound\WalletRepositoryPort;

class WalletService
{
    private $walletRepository;

    public function __construct(WalletRepositoryPort $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function createWallet(int $customerId): int
    {
        return $this->walletRepository->createWallet($customerId);
    }
}
