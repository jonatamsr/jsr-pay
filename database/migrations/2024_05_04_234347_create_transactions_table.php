<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('payer_id');
            $table->unsignedInteger('payee_id');
            $table->unsignedInteger('transaction_status_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('customers');
            $table->foreign('payee_id')->references('id')->on('customers');
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses');

            $table->index('payer_id');
            $table->index('payee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
