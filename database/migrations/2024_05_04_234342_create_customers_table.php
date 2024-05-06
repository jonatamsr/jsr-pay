<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_type_id');
            $table->string('name', 100);
            $table->string('cpf', 11);
            $table->string('cnpj', 14);
            $table->string('email', 100);
            $table->string('password', 64);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_type_id')->references('id')->on('customer_types');
            $table->unique('cpf');
            $table->unique('cnpj');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
