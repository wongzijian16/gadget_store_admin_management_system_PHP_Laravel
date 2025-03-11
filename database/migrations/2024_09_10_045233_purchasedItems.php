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
        
        Schema::create('purchasedItems', function (Blueprint $table) {
            $table->integer('seq')->primary();
            $table->string("orderNo")->references('orderNo')->on('orders');
            $table->string('userID');
            $table->foreignId('id')->constrained('products');
            
            $table->string('itemName');
            $table->string('itemDesc')->nullable();
            $table->double('itemPrice');
            $table->integer('itemQuantity');
            $table->double('multipliedPrice');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::drop('purchasedItems');
    }
};
