<?php

use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route
Route::get('/dashboard', function () {
    $totalItems = class_exists(Ingredient::class) ? Ingredient::count() : 0;
    $totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;
    $totalSales = class_exists(Order::class) ? Order::count() : 0;
    $totalSuppliers = 0;
    $totalWaste = 0;

    // Ligtas na pag-check ng low stock
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

    // Kinukuha ang total revenue gamit ang Order model
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
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected Routes (Kailangan naka-login ang user)
Route::middleware('auth')->group(function () {
    // POS Routes
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';