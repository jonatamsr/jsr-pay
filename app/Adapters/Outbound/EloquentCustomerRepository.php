<?php

namespace App\Adapters\Outbound;

use App\Domain\Entities\Customer;
use App\Models\Customer as CustomerEloquentModel;
use App\Ports\Outbound\customerRepositoryPort;

class EloquentCustomerRepository implements customerRepositoryPort
{
    public function createCustomer(Customer $customer): void {
        $customerData = $customer->toArray();
        unset($customerData["id"]);
        $customerEloquentModel = CustomerEloquentModel::create($customerData);
    }
}
