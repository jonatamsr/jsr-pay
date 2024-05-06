<?php

namespace App\Adapters\Outbound;
use App\Ports\Outbound\NotificationServicePort;

class CompositeNotificationService implements NotificationServicePort
{
    private $smsService;
    private $emailService;

    public function __construct(SMSNotificationService $smsService, EmailNotificationService $emailService) {
        $this->smsService = $smsService;
        $this->emailService = $emailService;
    }

    public function notify(int $payeeCustomerId): void
    {
        $this->smsService->notify($payeeCustomerId);
        $this->emailService->notify($payeeCustomerId);
    }
}
