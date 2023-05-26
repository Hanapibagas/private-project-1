<?php

use App\Http\Controllers\Suplier\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("auth.login");
});

Auth::routes(['register' => false]);

Route::middleware('auth', 'checkroll:suplier')->group(function () {
    Route::get('/dashboard-suplier', [DashboardController::class, 'index_suplier'])->name('index_suplier');
});

Route::middleware('auth', 'checkroll:admin')->group(function () {
    Route::get('/dashboard-suplier', [DashboardController::class, 'index_suplier'])->name('index_suplier');
});

Route::middleware('auth', 'checkroll:gudang')->group(function () {
    Route::get('/dashboard-suplier', [DashboardController::class, 'index_suplier'])->name('index_suplier');
});
