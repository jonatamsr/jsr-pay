<?php

namespace App\Adapters\Outbound;
use App\Ports\Outbound\NotificationServicePort;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SomeAppNotificationService implements NotificationServicePort
{
    public function notifyBySms(int $payeeCustomerId): void
    {
        Http::fake([
            'notification/notify-by-sms' => Http::response(['message' => true], Response::HTTP_OK),
        ]);

        $response = json_decode(
            Http::post('notification/notify-by-sms')->getBody()->getContents(),
            true
        );

        //TODO: Criar mecanismo de retry em caso de falha
    }

    public function notifyByEmail(int $payeeCustomerId): void
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
