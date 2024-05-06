<?php

namespace App\Ports\Outbound;

interface WalletRepositoryPort
{
    public function createWallet(int $customerId): int;
    public function updateBalance(int $customerId, float $balance): void;
}
