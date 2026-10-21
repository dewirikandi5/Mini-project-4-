<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('products', ProductController::class);
Route::resource('suppliers', SupplierController::class)->except('show');

Route::prefix('stock')->name('stock.')->group(function () {
    Route::get('/', [StockController::class, 'index'])->name('index');
    Route::get('/create', [StockController::class, 'create'])->name('create');
    Route::post('/', [StockController::class, 'store'])->name('store');
});
