<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        return [
                'customer_id' => Customer::factory()->create()->id,
                'balance' => 1000.00,
        ];
    }
}
