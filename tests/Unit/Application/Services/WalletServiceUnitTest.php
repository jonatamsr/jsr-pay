<?php

namespace Tests\Unit\Application\Services;
use App\Application\Services\WalletService;
use App\Ports\Outbound\WalletRepositoryPort;
use Tests\TestCase;

class WalletServiceUnitTest extends TestCase
{
    private $walletRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->walletRepositoryMock = $this->createMock(WalletRepositoryPort::class);
        $this->app->instance(WalletRepositoryPort::class, $this->walletRepositoryMock);
    }

    public function testCreateWalletMustCallWalletRepositoryPort(): void
    {
        $fakeCustomerId = 1;

        $this->walletRepositoryMock->expects($this->once())
            ->method('createWallet')
            ->with($fakeCustomerId);

        /** @var WalletService */
        $service = app(WalletService::class);
        $service->createWallet($fakeCustomerId);
    }
}
