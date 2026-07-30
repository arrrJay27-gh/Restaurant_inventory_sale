<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WasteLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\WasteLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Your custom restaurant landing page design
Route::get('/', function () {
    return view('welcome');
});

// Secure system dashboard entry
Route::get('/dashboard', function () {
    $totalItems = Ingredient::count();
    $totalMenuItems = MenuItem::count();
    $totalSales = Sale::count();
    $totalSuppliers = Supplier::count();
    $totalWaste = WasteLog::count();
    $lowStock = Ingredient::whereColumn('current_stock', '<', 'min_stock')->count();

    return view('dashboard', compact(
        'totalItems', 
        'totalMenuItems', 
        'totalSales', 
        'totalSuppliers', 
        'totalWaste', 
        'lowStock'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

// Secure User Account Profile Settings Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRITICAL: This line automatically handles all Login, Logout, and Register pages securely via Breeze!
require __DIR__.'/auth.php';
