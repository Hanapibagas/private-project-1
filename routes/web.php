<?php

use App\Http\Controllers\Admin\BarangMasukAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Suplier\BahanBakuController;
use App\Http\Controllers\Suplier\DashboardController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\laporanController;
use App\Http\Controllers\Gudang\DashboardGudangController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Gudang\BahanBakuLayakController;
use App\Http\Controllers\Gudang\ProduksiController;
use App\Http\Controllers\Gudang\TransaksiGudangController;
use App\Http\Controllers\Suplier\BahanKeluarController;
use App\Http\Controllers\Suplier\TransaksiSuplierController;

Route::get('/', function () {
    return view("auth.login");
});

Auth::routes();

Route::middleware('auth', 'checkroll:suplier')->group(function () {
    Route::get('/dashboard-suplier', [DashboardController::class, 'index_suplier'])->name('index_suplier');
    //
    Route::get('/barang-keluar-suplier', [BahanKeluarController::class, 'getIndex'])->name('getIndexBarangKeluar');
    //
    Route::get('/transaksi', [TransaksiSuplierController::class, 'getTransaksi'])->name('get.transaksi.suplier');
    Route::put('/transaksi/{id}', [TransaksiSuplierController::class, 'getDetails'])->name('get.update.suplier');
    //
    Route::get('/bahan-baku-suplier', [BahanBakuController::class, 'index_bahan_baku_suplier'])->name('index_bahan_baku_suplier');
    Route::get('/bahan-baku-suplier/create', [BahanBakuController::class, 'create_bahan_baku_suplier'])->name('create_bahan_baku_suplier');
    Route::post('/bahan-baku-suplier/store', [BahanBakuController::class, 'store_bahan_baku_suplier'])->name('store_bahan_baku_suplier');
    Route::get('/bahan-baku-suplier/edit/{id}', [BahanBakuController::class, 'edit_bahan_baku_suplier'])->name('edit_bahan_baku_suplier');
    Route::put('/bahan-baku-suplier/update/{id}', [BahanBakuController::class, 'update_bahan_baku_suplier'])->name('update_bahan_baku_suplier');
    Route::delete('/bahan-baku-suplier/delete/{id}', [BahanBakuController::class, 'destroy_bahan_baku_suplier'])->name('destroy_bahan_baku_suplier');
});

Route::middleware('auth', 'checkroll:admin')->group(function () {
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboard_admin'])->name('dashboard-admin');
    //
    Route::get('/laporan', [laporanController::class, 'getIndex'])->name('get.IndexLaporanAdmin');
    //
    Route::get('barang-masuk-admin', [BarangMasukAdminController::class, 'getIndex'])->name('getIndexBarangMasuk');
    //
    Route::controller(AdminProductController::class)->group(function () {
        Route::get('/product',  'indexProduct')->name('index-product');
        Route::get('/product/create',  'createProduct')->name('create-product');
        Route::post('/product/store',  'storeProduct')->name('store-product');
        Route::get('/product/edit/{id}',  'editProduct')->name('edit-product');
        Route::put('/product/update/{id}',  'updateProduct')->name('update-product');
        Route::delete('/product/delete{id}',  'deleteProduct')->name('delete-product');
    });

    Route::controller(TransaksiController::class)->group(function () {
        //get list transaksi
        Route::get('/list-transaksi',  'getTransaksi')->name('get.transaksi');
        Route::get('/get-bukti-bayar/{id}',  'getBuktibayar')->name('get.buktibayar');
        //get bahan baku
        Route::get('/list-bahan-baku',  'getBahanBaku')->name('get.bahanbaku');
        //cart
        Route::post('/store-cart',  'storeCart')->name('store.cart');
        Route::get('/get-cart',  'getCart')->name('get.cart');
        Route::get('/delete-cart/{id}',  'deleteCart')->name('delete.cart');
        //checkout
        Route::post('/checkout',  'checkout')->name('checkout');
        Route::post('/payment',  'payment')->name('payment');
        Route::get('/print-nota/{id}',  'printNota')->name('print.nota');
    });
});

Route::middleware('auth', 'checkroll:gudang')->group(function () {
    Route::get('/dashboard-gudang', [DashboardGudangController::class, 'dashboard_gudang'])->name('dashboard_gudang');
    //
    Route::get('/product-produksi', [ProduksiController::class, 'getIndex'])->name('get.IndexProduct');
    Route::post('/product-produksi/post', [ProduksiController::class, 'getStore'])->name('get.StoreProductExpired');
    Route::put('/product-produksi/update/{id}', [ProduksiController::class, 'getUpdate'])->name('get.UpdateProductExpired');
    Route::delete('/product-produksi/delete/{id}', [ProduksiController::class, 'getDestroy'])->name('get.DeleteProductExpired');
    //
    Route::get('/layak-produksi', [BahanBakuLayakController::class, 'getIndex'])->name('get.IndexLayakProduksi');
    Route::get('/layak-produksi/create', [BahanBakuLayakController::class, 'getCreate'])->name('get.CreateLayakProduksi');
    Route::post('/layak-produksi/post', [BahanBakuLayakController::class, 'getStore'])->name('get.PostLayakProduct');
    Route::put('/layak-produksi/update/{id}', [BahanBakuLayakController::class, 'getUpdate'])->name('get.UpdateLayakProduct');
    Route::delete('/layak-produksi/delete/{id}', [BahanBakuLayakController::class, 'getDestroy'])->name('get.Destroy');
    //
    Route::get('/rekap-transaksi', [TransaksiGudangController::class, 'getIndex'])->name('getIndexRekapTransaksi');
    Route::get('/rekap-transaksi/exportPDF', [TransaksiGudangController::class, 'getPrintToPDF'])->name('getPrintToPDF');
});
