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
        
        Schema::create('cartItems', function (Blueprint $table) {
            $table->integer('seq')->primary();
            $table->foreignId('id')->constrained('products');
            
            $table->string('cartID');
            $table->string('userID'); //TO be foreign key from user table
            
            $table->string('itemName');
            $table->string('itemDesc')->nullable();
            $table->double('itemPrice');
            $table->integer('itemQuantity')->default(1);
            $table->double('multipliedPrice');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('orders');
        Schema::drop('cartItems');
    }
};
