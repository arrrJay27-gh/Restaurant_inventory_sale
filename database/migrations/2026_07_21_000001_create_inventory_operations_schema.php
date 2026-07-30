<?php 

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 

class CreateInventoryOperationsSchema extends Migration { 
    /** * Run the migrations. */ 
    public function up(): void { 
        if (! Schema::hasTable('users')) { 
            Schema::create('users', function (Blueprint $table) { 
                $table->id(); 
                $table->string('name'); 
                $table->string('email')->unique(); 
                $table->timestamp('email_verified_at')->nullable(); 
                $table->string('password'); 
                $table->rememberToken(); 
                $table->timestamps(); 
            }); 
        } 

        if (! Schema::hasColumn('users', 'role')) { 
            Schema::table('users', function (Blueprint $table) { 
                $table->string('role')->default('cashier'); 
            }); 
        } 

        if (! Schema::hasTable('items')) { 
            Schema::create('items', function (Blueprint $table) { 
                $table->id(); 
                $table->string('name'); 
                $table->string('sku')->unique(); 
                $table->string('category')->nullable(); 
                $table->string('unit'); 
                $table->decimal('current_stock', 10, 3)->default(0); 
                $table->decimal('min_stock', 10, 3)->default(0); 
                $table->decimal('cost_per_unit', 10, 2)->default(0); 
                $table->timestamps(); 
            }); 
        } else { 
            Schema::table('items', function (Blueprint $table) { 
                if (! Schema::hasColumn('items', 'sku')) { $table->string('sku')->nullable(); } 
                if (! Schema::hasColumn('items', 'category')) { $table->string('category')->nullable(); } 
                if (! Schema::hasColumn('items', 'description')) { $table->text('description')->nullable(); } 
            }); 
        } 

        if (! Schema::hasTable('menu_items')) { 
            Schema::create('menu_items', function (Blueprint $table) { 
                $table->id(); 
                $table->string('name'); 
                $table->string('category')->default('Main'); 
                $table->decimal('price', 10, 2); 
                $table->boolean('is_active')->default(true); 
                $table->timestamps(); 
            }); 
        } else { 
            Schema::table('menu_items', function (Blueprint $table) { 
                if (! Schema::hasColumn('menu_items', 'category')) { $table->string('category')->default('Main'); } 
                if (! Schema::hasColumn('menu_items', 'is_active')) { $table->boolean('is_active')->default(true); } 
            }); 
        } 

        if (! Schema::hasTable('recipes')) { 
            Schema::create('recipes', function (Blueprint $table) { 
                $table->id(); 
                $table->foreignId('menu_item_id')->constrained()->cascadeOnDelete(); 
                $table->foreignId('item_id')->constrained()->cascadeOnDelete(); 
                $table->decimal('quantity_required', 10, 3); 
                $table->timestamps(); 
            }); 
        } else { 
            Schema::table('recipes', function (Blueprint $table) { 
                if (! Schema::hasColumn('recipes', 'quantity_required')) { $table->decimal('quantity_required', 10, 3)->default(0); } 
            }); 
        } 

        if (! Schema::hasTable('sales')) { 
            Schema::create('sales', function (Blueprint $table) { 
                $table->id(); 
                $table->string('sale_number')->unique(); 
                $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
                $table->string('order_type')->default('counter'); 
                $table->string('payment_method'); 
                $table->decimal('total_amount', 10, 2); 
                $table->string('status')->default('completed'); 
                $table->timestamps(); 
            }); 
        } else { 
            Schema::table('sales', function (Blueprint $table) { 
                if (! Schema::hasColumn('sales', 'sale_number')) { $table->string('sale_number')->nullable(); } 
                if (! Schema::hasColumn('sales', 'user_id')) { $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); } 
                if (! Schema::hasColumn('sales', 'order_type')) { $table->string('order_type')->default('counter'); } 
                if (! Schema::hasColumn('sales', 'payment_method')) { $table->string('payment_method')->nullable(); } 
                if (! Schema::hasColumn('sales', 'status')) { $table->string('status')->default('completed'); } 
            }); 
        } 

        if (! Schema::hasTable('sale_items')) { 
            Schema::create('sale_items', function (Blueprint $table) { 
                $table->id(); 
                $table->foreignId('sale_id')->constrained()->cascadeOnDelete(); 
                $table->foreignId('menu_item_id')->constrained(); 
                $table->integer('quantity'); 
                $table->decimal('unit_price', 10, 2); 
                $table->timestamps(); 
            }); 
        } else { 
            Schema::table('sale_items', function (Blueprint $table) { 
                if (! Schema::hasColumn('sale_items', 'menu_item_id')) { $table->foreignId('menu_item_id')->nullable()->constrained(); } 
                if (! Schema::hasColumn('sale_items', 'quantity')) { $table->integer('quantity')->default(1); } 
                if (! Schema::hasColumn('sale_items', 'unit_price')) { $table->decimal('unit_price', 10, 2)->default(0); } 
            }); 
        } 

        if (! Schema::hasTable('suppliers')) { 
            Schema::create('suppliers', function (Blueprint $table) { 
                $table->id(); 
                $table->string('name'); 
                $table->string('contact_name')->nullable(); 
                $table->string('phone')->nullable(); 
                $table->string('email')->nullable(); 
                $table->timestamps(); 
            }); 
        } 

        if (! Schema::hasTable('purchase_orders')) { 
            Schema::create('purchase_orders', function (Blueprint $table) { 
                $table->id(); 
                $table->string('po_number')->unique(); 
                $table->foreignId('supplier_id')->constrained()->cascadeOnDelete(); 
                $table->string('status')->default('draft'); 
                $table->decimal('total_amount', 10, 2)->default(0); 
                $table->timestamps(); 
            }); 
        } 

        if (! Schema::hasTable('po_items')) {
            Schema::create('po_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('po_id')->constrained()->cascadeOnDelete();
                $table->foreignId('item_id')->constrained()->cascadeOnDelete();
                $table->decimal('quantity_ordered', 10, 3);
                $table->decimal('unit_cost', 10, 2);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('waste_logs')) { 
            Schema::create('waste_logs', function (Blueprint $table) { 
                $table->id(); 
                $table->foreignId('item_id')->constrained()->cascadeOnDelete(); 
                $table->decimal('quantity', 10, 3); 
                $table->string('reason'); 
                $table->foreignId('logged_by')->constrained('users')->cascadeOnDelete(); 
                $table->timestamps(); 
            }); 
        } 
    } 

    /** * Reverse the migrations. */ 
    public function down(): void { 
        Schema::dropIfExists('waste_logs'); 
        Schema::dropIfExists('po_items'); 
        Schema::dropIfExists('purchase_orders'); 
        Schema::dropIfExists('suppliers'); 
        Schema::dropIfExists('sale_items'); 
        Schema::dropIfExists('sales'); 
        Schema::dropIfExists('recipes'); 
        Schema::dropIfExists('menu_items'); 
        Schema::dropIfExists('items'); 
        if (Schema::hasColumn('users', 'role')) { 
            Schema::table('users', function (Blueprint $table) { 
                $table->dropColumn('role'); 
            }); 
        } 
    } 
};
