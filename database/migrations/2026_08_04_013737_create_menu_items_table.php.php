<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pangalan ng produkto (e.g., Taro Milk Tea)
            $table->string('category')->nullable(); // Kategorya (e.g., Milk Tea, Coffee)
            $table->decimal('price', 10, 2); // Presyo sa POS checkout
            $table->boolean('is_active')->default(true); // Kung ibinebenta pa ba o hindi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
