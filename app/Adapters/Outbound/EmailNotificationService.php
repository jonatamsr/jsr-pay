<?php

namespace App\Adapters\Outbound;
use App\Ports\Outbound\NotificationServicePort;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class EmailNotificationService implements NotificationServicePort
{
    public function notify(int $payeeCustomerId): void
    {
        Http::fake([
            'auth/notify-by-email' => Http::response(['message' => true], Response::HTTP_OK),
        ]);

        $response = json_decode(
            Http::post('auth/notify-by-email')->getBody()->getContents(),
            true
        );

        //TODO: Criar mecanismo de retry em caso de falha
    }
}
