<?php

use App\Adapters\Inbound\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'Api is standing!');
Route::post('/customer', [CustomerController::class, 'createCustomer']);
