<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\WasteLog;

Route::get('/', function () {
    return view('welcome');
});

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
