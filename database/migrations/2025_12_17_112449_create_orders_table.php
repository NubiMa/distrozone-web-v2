<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Order Status
            $table->enum('status', [
                'pending_payment',      // Waiting for customer to upload payment proof
                'pending_verification', // Payment uploaded, waiting for cashier
                'verified',             // Payment verified by cashier
                'processing',           // Order being prepared
                'shipped',              // Order shipped
                'delivered',            // Order delivered
                'cancelled',            // Order cancelled
                'rejected'              // Payment rejected
            ])->default('pending_payment');

            // Pricing
            $table->decimal('subtotal', 15, 2); // Total product price
            $table->decimal('shipping_cost', 15, 2);
            $table->decimal('total', 15, 2); // Subtotal + shipping
            
            // Shipping Information
            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            $table->text('shipping_address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code', 10)->nullable();
            
            // Shipping Details
            $table->integer('total_weight'); // In grams
            $table->integer('shipping_weight'); // Calculated weight in kg
            
            // Notes
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Tracking
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('order_number');
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};