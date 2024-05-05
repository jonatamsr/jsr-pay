<?php

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Seed the transaction_statuses table.
     *
     * @return void
     */
    public function run(): void
    {
        TransactionStatus::firstOrCreate(
            ['id' => 1],
            ['status' => 'processing']
        );

        TransactionStatus::firstOrCreate(
            ['id' => 2],
            ['status' => 'success']
        );

        TransactionStatus::firstOrCreate(
            ['id' => 3],
            ['status' => 'error']
        );
    }
}