<?php

namespace App\Adapters\Inbound\Controllers;

use App\Ports\Inbound\CustomerServicePort;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServicePort $customerService) {
        $this->customerService = $customerService;
    }

    public function createCustomer(Request $request): JsonResponse
    {
        $this->customerService->createCustomer($request->all());

        return response()->json('Customer created successfully!', 201);
    }	
}
