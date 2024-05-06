<?php

use App\Adapters\Outbound\EloquentCustomerRepository;
use App\Application\Services\CustomerService;
use App\Ports\Inbound\CustomerServicePort;
use App\Ports\Outbound\customerRepositoryPort;

return [
    CustomerServicePort::class => CustomerService::class,
    customerRepositoryPort::class => EloquentCustomerRepository::class,
];
