<?php

namespace Tests\Unit\Application\Listeners;

use App\Application\Listeners\CustomerCreatedListener;
use App\Application\Services\WalletService;
use App\Domain\Events\CustomerCreated;
use Illuminate\Events\Dispatcher;
use Tests\TestCase;

class CustomerCreatedListenerUnitTest extends TestCase
{
    public function testCustomerCreatedListenerIsHandlingEventDispatches(): void
    {
        $fakeCustomerId = 1;
        $fakeEvent = new CustomerCreated($fakeCustomerId);

        $listenerMock = $this->createMock(CustomerCreatedListener::class);
        $this->app->instance(CustomerCreatedListener::class, $listenerMock);
        $listenerMock->expects($this->once())
            ->method('handle')
            ->with($fakeEvent);

        /** @var Dispatcher @dispatcher */
        $dispatcher = app(Dispatcher::class);
        $dispatcher->dispatch($fakeEvent);
    }

    public function testCustomerCreatedListenerIsCallingWalletService(): void
    {
        $fakeCustomerId = 1;
        $fakeEvent = new CustomerCreated($fakeCustomerId);

        $walletServiceMock = $this->createMock(WalletService::class);
        $this->app->instance(WalletService::class, $walletServiceMock);
        $walletServiceMock->expects($this->once())
            ->method('createWallet')
            ->with($fakeCustomerId);

        /** @var CustomerCreatedListener @listener */
        $listener = app(CustomerCreatedListener::class);

        $listener->handle($fakeEvent);
    }
}
