<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::view('/', 'welcome')->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/productos', [ProductController::class, 'store'])->name('products.store');
Route::get('/productos/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/productos/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categorias/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categorias/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categorias/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
