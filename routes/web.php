<?php

use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\WasteLogController;
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root URL (127.0.0.1:8000)
// Binago natin ito: Direktang pupunta sa landing page ('welcome')
// kahit naka-login o naka-guest para hindi ka ma-lock sa /pos!
Route::get('/', function () {
    return view('welcome'); // Siguraduhing 'welcome' ang pangalan ng landing page blade file mo
})->name('home');

// 1. ADMIN, STAFF & INVENTORY MANAGER EXCLUSIVE ROUTES (Sidebar Dashboard)
Route::middleware(['auth', 'verified', 'role:admin,inventory_manager,staff,manager,inventory manager'])->group(function () {

    Route::get('/dashboard', function () {
        $totalItems = class_exists(Ingredient::class) ? Ingredient::count() : 0;
        $totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;
        $totalSales = class_exists(Order::class) ? Order::count() : 0;
        $totalSuppliers = 0;
        $totalWaste = 0;

        $lowStock = 0;
        if (class_exists(Ingredient::class)) {
            try {
                $lowStock = Ingredient::whereColumn('current_stock', '<', 'min_stock')->count();
            } catch (\Exception $e) {
                try {
                    $lowStock = Ingredient::whereColumn('stock', '<', 'min_stock')->count();
                } catch (\Exception $ex) {
                    $lowStock = 0;
                }
            }
        }

        $totalRevenue = class_exists(Order::class) ? (Order::sum('total_amount') ?? 0) : 0;

        return view('dashboard', compact(
            'totalItems',
            'totalMenuItems',
            'totalSales',
            'totalSuppliers',
            'totalWaste',
            'lowStock',
            'totalRevenue'
        ));
    })->name('dashboard');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/waste-logs', [WasteLogController::class, 'index'])->name('waste-logs.index');
});

// 2. POS ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/pos', function () {
        $cleanRole = strtolower(str_replace([' ', '_'], '', Auth::user()->role ?? ''));

        // Kung tinangka ng Admin/Staff na mag-open ng /pos -> Ibalik sa Dashboard!
        if (in_array($cleanRole, ['admin', 'staff', 'manager', 'inventorymanager'])) {
            return redirect()->route('dashboard');
        }

        return app(PosController::class)->index();
    })->name('pos.index');

    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';