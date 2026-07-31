<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Order;
use App\Http\Controllers\PosController;

Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalItems = class_exists(Ingredient::class) ? Ingredient::count() : 0;
    $totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;
    $totalSales = class_exists(Order::class) ? Order::count() : 0;
    $totalSuppliers = 0;
    $totalWaste = 0;
    $lowStock = 0;

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