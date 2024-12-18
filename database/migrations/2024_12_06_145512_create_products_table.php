<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // Price with 2 decimal places
            $table->string('image_url')->nullable(); // URL for product image
            $table->boolean('is_hot')->default(false); // Mark as "Hot Product"
            $table->boolean('is_featured')->default(false); // Mark as "Featured Product for Banner"
            $table->unsignedBigInteger('views')->default(0); // Number of views
            $table->unsignedBigInteger('sales')->default(value: 0); // Number of sales
            $table->unsignedBigInteger('category_id'); // Foreign key to categories
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
