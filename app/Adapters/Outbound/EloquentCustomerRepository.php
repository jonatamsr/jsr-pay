<?php

namespace App\Adapters\Outbound;

use App\Domain\Entities\Customer;
use App\Models\Customer as CustomerEloquentModel;
use App\Ports\Outbound\CustomerRepositoryPort;

class EloquentCustomerRepository extends Repository implements CustomerRepositoryPort 
{
    protected $entity = Customer::class;

    public function createCustomer(Customer $customer): int
    {
        $customerData = $customer->toArray();
        unset($customerData["id"]);
        $customerEloquentModel = CustomerEloquentModel::create($customerData);

        return $customerEloquentModel->id;
    }

    public function getCustomerByEmail(string $email): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('email', $email)->first());
    }

    public function getCustomerByCpf(string $cpf): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('cpf', $cpf)->first());
    }

    public function getCustomerByCnpj(string $cnpj): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('cnpj', $cnpj)->first());
    }
}
