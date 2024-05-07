<?php

namespace App\Adapters\Inbound\Controllers;

use App\Ports\Inbound\CustomerServicePort;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function __construct(private CustomerServicePort $customerService)
    {
        $this->customerService = $customerService;
    }

    public function createCustomer(Request $request): JsonResponse
    {
        $this->customerService->createCustomer($request->all());

        return response()->json('Customer created successfully!', Response::HTTP_CREATED);
    }
}
