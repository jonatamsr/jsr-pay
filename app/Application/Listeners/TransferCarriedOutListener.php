<?php

namespace App\Application\Listeners;

use App\Domain\Events\TransferCarriedOut;
use App\Ports\Outbound\NotificationServicePort;

class TransferCarriedOutListener
{
    public function __construct(private NotificationServicePort $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(TransferCarriedOut $event)
    {
        $this->notificationService->notify($event->payeeCustomerId);
    }
}
