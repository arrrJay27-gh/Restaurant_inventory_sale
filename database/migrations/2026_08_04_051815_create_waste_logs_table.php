<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('waste_logs', function (Blueprint $table) {
            function (Blueprint $table) {
                $table->id();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            };
        });

        Schema::create('waste_log_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_log_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_log_items');
        Schema::dropIfExists('waste_logs');
    }
};