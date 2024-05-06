<?php

namespace App\Ports\Outbound;

interface NotificationServicePort
{
    public function notifyBySms(int $payeeCustomerId): void;
    public function notifyByEmail(int $payeeCustomerId): void;
}
