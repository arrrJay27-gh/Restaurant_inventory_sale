<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

// Root URL
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. INVENTORY (Raw ingredients / Stocks lang)
    Route::get('/inventory', [ItemController::class, 'index'])->name('inventory.index');
    Route::resource('items', ItemController::class);

    // 2. MENU MANAGEMENT (Dito makikita ang mga BINEBENTANG PRODUCTS/MENU)
    Route::get('/menu-management', [MenuController::class, 'index'])->name('menu.index');

    // ADMIN ONLY: Route para makapag-ADD ng BAGONG MENU / PRODUCT
    Route::middleware('role:admin')->group(function () {
        Route::get('/menu-management/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('/menu-management', [MenuController::class, 'store'])->name('menu.store');
    });

    // 3. POS SCREEN (Order Processing / Cashier)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // Purchase Orders & Sales
    Route::resource('purchase-orders', PurchaseOrderController::class)->except(['create', 'store']);
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::resource('sales', SalesController::class)->except(['index']);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';