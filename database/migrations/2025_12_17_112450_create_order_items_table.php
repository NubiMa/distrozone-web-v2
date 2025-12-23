<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('product_variant_id')->constrained();
            
            // Snapshot data (to preserve historical order info)
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('variant_color');
            $table->string('variant_size');
            $table->integer('quantity');
            $table->decimal('price', 15, 2); // Price per item at time of order
            $table->decimal('cost_price', 15, 2); // Cost for profit calculation
            $table->decimal('subtotal', 15, 2); // price * quantity
            
            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};