<?php

use App\Adapters\Outbound\EloquentCustomerRepository;
use App\Adapters\Outbound\EloquentWalletRepository;
use App\Application\Services\CustomerService;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use App\Ports\Outbound\WalletRepositoryPort;

return [
    // Customer
    CustomerServicePort::class => CustomerService::class,
    CustomerRepositoryPort::class => EloquentCustomerRepository::class,

    // Wallet
    WalletRepositoryPort::class => EloquentWalletRepository::class,
];
