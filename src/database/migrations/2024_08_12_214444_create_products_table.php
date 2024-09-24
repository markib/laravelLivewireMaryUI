<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            /*
             * Foreign key to product_category table.
             */
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id', 'fk_product_product_category')
                ->references('id')->on('product_categories');

            $table->text('description');
            $table->integer('selling_price');
            $table->string('image_path');

            $table->integer('stock_count')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
