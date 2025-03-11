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
        Schema::disableForeignKeyConstraints();
        
        Schema::create('orders', function (Blueprint $table) {
            $table->string('orderNo')->primary();
            $table->string('cartID');
            $table->string('userID');
            $table->float('totalPrice');
            $table->string('status')->default('Pending');
            $table->string('paymentMethod')->default('Not Selected')->references('name')->on('paymentMethods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('orders');
    }
};
