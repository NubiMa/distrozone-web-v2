<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_method')->default('bank_transfer');
            $table->decimal('amount', 15, 2);
            
            // Payment Proof
            $table->string('proof_image_path')->nullable();
            $table->timestamp('proof_uploaded_at')->nullable();
            
            // Bank Information (from customer)
            $table->string('sender_bank_name')->nullable();
            $table->string('sender_account_name')->nullable();
            $table->string('sender_account_number')->nullable();
            
            // Verification
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};