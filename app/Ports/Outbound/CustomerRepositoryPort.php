<?php

namespace App\Ports\Outbound;

use App\Domain\Entities\Customer;
use App\Domain\Entities\Wallet;

interface CustomerRepositoryPort
{
    public function createCustomer(Customer $customer): int;
    public function getCustomerByEmail(string $email): ?Customer;
    public function getCustomerByCpf(string $email): ?Customer;
    public function getCustomerByCnpj(string $email): ?Customer;
    public function getCustomerById(int $customerId): ?Customer;
    public function getCustomerWallet(int $customerId): Wallet;
}
