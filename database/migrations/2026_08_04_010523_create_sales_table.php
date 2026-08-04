<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            
            // Customer Info (Can change to a foreignId if you have a customers table)
            $table->string('customer_name')->nullable(); 
            
            // Amounts
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2);
            
            // Status & Attribution
            $table->enum('payment_status', ['paid', 'pending', 'refunded'])->default('pending');
            $table->enum('fulfillment_status', ['unfulfilled', 'fulfilled'])->default('unfulfilled');
            $table->string('processed_by'); // e.g., "Ma Princess Dian Romualdo"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

