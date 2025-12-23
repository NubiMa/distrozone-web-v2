<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color');
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']);
            $table->string('sku')->unique(); // Unique SKU for each variant
            $table->decimal('price', 15, 2); // Can differ from base price
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5); // Alert threshold
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index('product_id');
            $table->index('sku');
            $table->unique(['product_id', 'color', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};