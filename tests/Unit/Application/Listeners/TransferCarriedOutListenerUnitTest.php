<?php

namespace Tests\Unit\Application\Listeners;

use App\Adapters\Outbound\CompositeNotificationService;
use App\Application\Listeners\TransferCarriedOutListener;
use App\Domain\Events\TransferCarriedOut;
use Illuminate\Events\Dispatcher;
use Tests\TestCase;

class TransferCarriedOutListenerUnitTest extends TestCase
{
    public function testTransferCarriedOutListenerIsHandlingEventDispatches(): void
    {
        $fakeCustomerPayeeId = 1;
        $fakeEvent = new TransferCarriedOut($fakeCustomerPayeeId);

        $listenerMock = $this->createMock(TransferCarriedOutListener::class);
        $this->app->instance(TransferCarriedOutListener::class, $listenerMock);
        $listenerMock->expects($this->once())
            ->method('handle')
            ->with($fakeEvent);

        /** @var Dispatcher @dispatcher */
        $dispatcher = app(Dispatcher::class);
        $dispatcher->dispatch($fakeEvent);
    }

    public function testCustomerCreatedListenerIsCallingWalletService(): void
    {
        $fakeCustomerPayeeId = 1;
        $fakeEvent = new TransferCarriedOut($fakeCustomerPayeeId);

        $notificationServiceMock = $this->createMock(CompositeNotificationService::class);
        $this->app->instance(CompositeNotificationService::class, $notificationServiceMock);
        $notificationServiceMock->expects($this->once())
            ->method('notify')
            ->with($fakeCustomerPayeeId);

        /** @var TransferCarriedOutListener @listener */
        $listener = app(TransferCarriedOutListener::class);

        $listener->handle($fakeEvent);
    }
}
