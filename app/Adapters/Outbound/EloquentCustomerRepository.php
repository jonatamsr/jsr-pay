<?php

namespace App\Adapters\Outbound;

use App\Domain\Entities\Customer;
use App\Models\Customer as CustomerEloquentModel;
use App\Ports\Outbound\CustomerRepositoryPort;

class EloquentCustomerRepository implements CustomerRepositoryPort
{
    public function createCustomer(Customer $customer): int
    {
        $customerData = $customer->toArray();
        unset($customerData["id"]);
        $customerEloquentModel = CustomerEloquentModel::create($customerData);

        return $customerEloquentModel->id;
    }
}
