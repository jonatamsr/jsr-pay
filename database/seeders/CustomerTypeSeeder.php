<?php

use App\Models\CustomerType;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Seed the customer_types table.
     *
     * @return void
     */
    public function run(): void
    {
        CustomerType::firstOrCreate(
            ['id' => 1],
            ['type' => 'common']
        );

        CustomerType::firstOrCreate(
            ['id' => 2],
            ['type' => 'retailer']
        );
    }
}
