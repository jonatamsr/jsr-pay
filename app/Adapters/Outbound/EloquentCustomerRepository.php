<?php

namespace App\Adapters\Outbound;

use App\Domain\Entities\Customer;
use App\Domain\Entities\Wallet;
use App\Models\Customer as CustomerEloquentModel;
use App\Models\Wallet as WalletEloquentModel;
use App\Ports\Outbound\CustomerRepositoryPort;

class EloquentCustomerRepository extends Repository implements CustomerRepositoryPort 
{
    public function createCustomer(Customer $customer): int
    {
        $customerData = $customer->toArray();
        unset($customerData["id"]);
        $customerModel = CustomerEloquentModel::query()->create($customerData);

        return $customerModel->id;
    }

    public function getCustomerByEmail(string $email): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('email', $email)->first(), Customer::class);
    }

    public function getCustomerByCpf(string $cpf): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('cpf', $cpf)->first(), Customer::class);
    }

    public function getCustomerByCnpj(string $cnpj): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('cnpj', $cnpj)->first(), Customer::class);
    }

    public function getCustomerById(int $customerId): ?Customer
    {
        return $this->buildEntity(CustomerEloquentModel::where('id', $customerId)->first(), Customer::class);
    }

    public function getCustomerWallet(int $customerId): Wallet
    {
        return $this->buildEntity(WalletEloquentModel::where('customer_id', $customerId)->first(), Wallet::class);
    }
}
