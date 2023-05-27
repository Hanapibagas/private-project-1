<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Gudang\DashboardGudangController;
use App\Http\Controllers\Suplier\DashboardController;
use App\Http\Controllers\Suplier\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("auth.login");
});

Auth::routes();

Route::middleware('auth', 'checkroll:suplier')->group(function () {
    Route::get('/dashboard-suplier', [DashboardController::class, 'index_suplier'])->name('index_suplier');
    //
    Route::get('/product-suplier', [ProductController::class, 'index_product_suplier'])->name('index_product_suplier');
    Route::get('/product-suplier/create', [ProductController::class, 'create_product_suplier'])->name('create_product_suplier');
    Route::post('/product-suplier/store', [ProductController::class, 'store_product_suplier'])->name('store_product_suplier');
    Route::get('/product-suplier/edit/{id}', [ProductController::class, 'edit_product_suplier'])->name('edit_product_suplier');
    Route::put('/product-suplier/update/{id}', [ProductController::class, 'update_product_suplier'])->name('update_product_suplier');
    Route::delete('/product-suplier/delete/{id}', [ProductController::class, 'destroy_prodcut_suplier'])->name('destroy_prodcut_suplier');
});

Route::middleware('auth', 'checkroll:admin')->group(function () {
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboard_admin'])->name('dashboard_admin');
});

Route::middleware('auth', 'checkroll:gudang')->group(function () {
    Route::get('/dashboard-gudang', [DashboardGudangController::class, 'dashboard_gudang'])->name('dashboard_gudang');
});
