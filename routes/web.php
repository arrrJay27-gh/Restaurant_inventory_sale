<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WasteLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Your custom restaurant landing page design
Route::get('/', function () {
    return view('welcome');
});
Route::get('/stocks', [ItemController::class, 'index'])->name('stocks.index');

// FIXED: This now properly connects to your DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Secure User Account Profile Settings Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/items/{item}/adjust', [ItemController::class, 'adjustStock'])->name('items.adjust-stock');
    Route::patch('/items/{item}/adjust', [ItemController::class, 'updateStock'])->name('items.update-stock');
    Route::resource('suppliers', SupplierController::class);
    Route::get('/stocks', [ItemController::class, 'stockLogs'])->name('stocks.index');
    Route::resource('purchase-orders', PurchaseOrderController::class)->names('purchase_orders');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');
    Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::get('/waste-logs/create', [WasteLogController::class, 'create'])->name('waste-logs.create');
    Route::post('/waste-logs', [WasteLogController::class, 'store'])->name('waste-logs.store');
    
    Route::resource('items', ItemController::class);
});

// CRITICAL: This line automatically handles all Login, Logout, and Register pages securely via Breeze!
require __DIR__.'/auth.php';
