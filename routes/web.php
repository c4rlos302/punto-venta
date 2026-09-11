<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;

use App\Livewire\Sales\Create as CreateSales;
use App\Livewire\Sales\Index as IndexSales;

use App\Livewire\Inventory\Index as IndexInventory;
use App\Livewire\Inventory\Movements;

use App\Livewire\Users\Index as IndexUsers;
use App\Livewire\Users\Create as CreateUsers;
use App\Livewire\Users\Edit;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'active', 'admin'])->group(function () {
    Route::get('/usuarios', IndexUsers::class)->name('users.index');
    Route::get('/usuarios/nuevo', CreateUsers::class)->name('users.create');
    Route::get('/usuarios/{user}/editar', Edit::class)->name('users.edit');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/ventas', IndexSales::class)->name('sales.index');
    Route::get('/ventas/nueva', CreateSales::class)->name('sales.create');
    Route::get('/ventas/{sale}', [SaleController::class, 'show'])->name('sales.show');

    Route::get('/inventario', IndexInventory::class)->name('inventory.index');
    Route::get('/inventario/movimientos', Movements::class)->name('inventory.movements');

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
});

require __DIR__ . '/settings.php';
