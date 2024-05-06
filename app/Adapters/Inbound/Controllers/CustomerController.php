<?php

namespace App\Adapters\Inbound\Controllers;

use App\Ports\Inbound\CustomerServicePort;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerServicePort $customerService) {
        $this->customerService = $customerService;
    }

    public function createCustomer(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:100',
                'email' => 'required|string|max:100',
                'cpf' => 'required_if:customer_type_id, 1|exclude_if:customer_type_id, 2',
                'cnpj' => 'required_if:customer_type_id, 2|exclude_if:customer_type_id, 1',
                'password' => 'required|string',
                'customer_type_id' => 'required|integer|between:1, 2',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->customerService->createCustomer($validator->validated());

        return response()->json('Customer created successfully!', 201);
    }	
}
