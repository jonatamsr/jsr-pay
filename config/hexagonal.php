<?php

use App\Adapters\Outbound\CompositeNotificationService;
use App\Adapters\Outbound\EloquentCustomerRepository;
use App\Adapters\Outbound\EloquentTransactionRepository;
use App\Adapters\Outbound\EloquentWalletRepository;
use App\Adapters\Outbound\SomeAppAuthorizationService;
use App\Application\Services\CustomerService;
use App\Application\Services\TransactionService;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Inbound\TransactionServicePort;
use App\Ports\Outbound\AuthorizationServicePort;
use App\Ports\Outbound\CustomerRepositoryPort;
use App\Ports\Outbound\NotificationServicePort;
use App\Ports\Outbound\TransactionRepositoryPort;
use App\Ports\Outbound\WalletRepositoryPort;

return [
    // Customer
    CustomerServicePort::class => CustomerService::class,
    CustomerRepositoryPort::class => EloquentCustomerRepository::class,

    // Wallet
    WalletRepositoryPort::class => EloquentWalletRepository::class,

    // Transaction
    TransactionServicePort::class => TransactionService::class,
    TransactionRepositoryPort::class => EloquentTransactionRepository::class,

    // Auth
    AuthorizationServicePort::class => SomeAppAuthorizationService::class,

    // Notification
    NotificationServicePort::class => CompositeNotificationService::class,
];
