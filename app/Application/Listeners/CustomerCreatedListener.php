<?php

namespace App\Application\Listeners;

use App\Application\Services\WalletService;
use App\Domain\Events\CustomerCreated;

class CustomerCreatedListener
{
    public function __construct(private WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function handle(CustomerCreated $event)
    {
        $this->walletService->createWallet($event->customerId);
    }
}
