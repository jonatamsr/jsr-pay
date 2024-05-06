<?php

namespace App\Ports\Outbound;

interface WalletRepositoryPort
{
    public function createWallet(int $customerId): int;
}
