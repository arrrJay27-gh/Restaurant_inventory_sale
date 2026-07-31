<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WasteLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PosDashboardController;
use App\Http\Controllers\PosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () {

    // Main Dashboard Route
    Route::get('/dashboard', function () {
        $totalRevenue = DB::table('sales')->sum('total_amount') ?? 0;
        $totalSales = DB::table('sales')->count();

        return view('dashboard', compact('totalRevenue', 'totalSales'));
    })->name('dashboard');

    // POS Routes
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index'); // <-- Idinagdag para sa Open POS Register
    Route::get('/pos/dashboard', [PosDashboardController::class, 'index'])->name('pos.dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Authentication Routes (Breeze)
require __DIR__.'/auth.php';