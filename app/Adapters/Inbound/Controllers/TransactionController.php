<?php

namespace App\Adapters\Inbound\Controllers;

use App\Ports\Inbound\TransactionServicePort;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionController
{
    public function __construct(private TransactionServicePort $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transfer(Request $request): JsonResponse
    {
        $this->transactionService->transfer($request->all());

        return response()->json('Transaction carried out!', Response::HTTP_OK);
    }
}
