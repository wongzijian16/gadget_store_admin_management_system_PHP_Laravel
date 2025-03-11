<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->foreignId('category_id')->constrained('categories'); // Foreign key to categories table
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('video_url');  // Remove this line on rollback
    });
    }
};
