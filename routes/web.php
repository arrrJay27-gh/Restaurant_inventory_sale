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

use Illuminate\Support\Facades\DB;

Route::get('/dashboard', function () {
    // Kukunin ang kabuuang suma ng total_amount mula sa sales table. 
    // Kung walang benta, gagawin itong 0.
    $totalRevenue = DB::table('sales')->sum('total_amount') ?? 0;
    
    // Kukunin ang kabuuang bilang ng mga transaksyon sa sales table.
    $totalSales = DB::table('sales')->count();

    // Ipapasa ang mga variable papunta sa iyong dashboard blade file
    return view('dashboard', compact('totalRevenue', 'totalSales'));
})->middleware(['auth', 'verified'])->name('dashboard');


// Secure User Account Profile Settings Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CRITICAL: This line automatically handles all Login, Logout, and Register pages securely via Breeze!
require __DIR__.'/auth.php';
