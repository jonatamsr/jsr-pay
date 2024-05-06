<?php

use App\Adapters\Inbound\Controllers\CustomerController;
use App\Adapters\Inbound\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'Api is standing!');
Route::post('/customer', [CustomerController::class, 'createCustomer']);
Route::post('/transfer', [TransactionController::class, 'transfer']);
