<?php

namespace App\Application\Listeners;

use App\Domain\Events\TransferCarriedOut;
use App\Ports\Outbound\NotificationServicePort;

class TransferCarriedOutListener
{
    private $notificationService;

    public function __construct(NotificationServicePort $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(TransferCarriedOut $event)
    {
        $this->notificationService->notify($event->payeeCustomerId);
    }
}
