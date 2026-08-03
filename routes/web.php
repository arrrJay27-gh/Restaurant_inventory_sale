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
    
    Route::resource('items', ItemController::class);
});

// CRITICAL: This line automatically handles all Login, Logout, and Register pages securely via Breeze!
require __DIR__.'/auth.php';
