<?php

namespace App\Ports\Outbound;

interface NotificationServicePort
{
    public function notify(int $payeeCustomerId): void;
}
