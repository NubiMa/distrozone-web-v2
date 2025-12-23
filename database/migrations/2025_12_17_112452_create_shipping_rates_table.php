<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('province');
            $table->decimal('rate_per_kg', 15, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['city', 'province']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};