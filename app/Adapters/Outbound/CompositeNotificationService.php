<?php

namespace App\Adapters\Outbound;

use App\Ports\Outbound\NotificationServicePort;

class CompositeNotificationService implements NotificationServicePort
{
    public function __construct(
        private SMSNotificationService $smsService,
        private EmailNotificationService $emailService
    ) {
        $this->smsService = $smsService;
        $this->emailService = $emailService;
    }

    public function notify(int $payeeCustomerId): void
    {
        $this->smsService->notify($payeeCustomerId);
        $this->emailService->notify($payeeCustomerId);
    }
}
