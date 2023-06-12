<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\User;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function getBahanBaku()
    {
        $data = BahanBaku::where('stok', '>', 0)->simplePaginate(12);
        return view('component.admin.transaksi.bahanbaku', compact('data'));
    }

    public function getCart()
    {
        $data = Cart::all();
        return view('component.admin.transaksi.cart', compact('data'));
    }

    public function storeCart(Request $request)
    {
        $duplicate = Cart::where('bahanbaku_id', $request->bahan_baku)->first();

        if ($duplicate) {
            return redirect()->back()->with('warning', 'Item sudah ada dalam keranjang');
        }

        $data = new Cart();
        $data->bahanbaku_id = $request->bahan_baku;
        $data->jumlah = 1;
        $data->save();

        return redirect()->back()->with('status', 'Berhasil menambah item ke keranjang');
    }

    public function deleteCart($id)
    {
        $data = Cart::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus item di keranjang');
    }

    public function checkout(Request $request)
    {

        $bahanBakuIds = $request->input('bahan_baku');
        $quantities = $request->input('quantity');
        $total = $request->input('subtotal');

        dd($total);

<<<<<<< HEAD
        $selectedItems = [];
        foreach ($bahanBakuIds as $bahanBakuId) {
            if (isset($quantities[$bahanBakuId])) {
                $selectedItems[$bahanBakuId] = $quantities[$bahanBakuId];
            }
=======
    $bahanBakuIds = $request->input('bahan_baku');
    $quantities = $request->input('quantity');
    $subtotals = $request->input('subtotal');

    $selectedItems_qty = [];
    $selectedItems_sub = [];
    foreach ($bahanBakuIds as $bahanBakuId) {
        if (isset($quantities[$bahanBakuId])) {
            $selectedItems_qty[$bahanBakuId] = $quantities[$bahanBakuId];
        }
        if (isset($subtotals[$bahanBakuId])) {
            $selectedItems_sub[$bahanBakuId] = $subtotals[$bahanBakuId];
>>>>>>> e3e05f7ae74cbe2470e0e6b98cc049316c247229
        }

<<<<<<< HEAD
        $data = [];
        foreach ($selectedItems as $bahanBakuId => $quantity) {
            $bahanBaku = BahanBaku::find($bahanBakuId);
            $data[] = ['bahan_baku' => $bahanBakuId, 'quantity' => $quantity];
        }
        $suplier = [];
        for ($i = 0; $i < count($request->bahan_baku); $i++) {
            $bahan_baku = BahanBaku::findOrFail($request->bahan_baku[$i]);
            $suplier[] = $bahan_baku->users->id;
=======
    $data_qty = [];
    foreach ($selectedItems_qty as $bahanBakuId => $quantity) {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        $data_qty[] = ['bahan_baku' => $bahanBakuId , 'quantity' => $quantity];
    }

    $data_sub = [];
    foreach ($selectedItems_sub as $bahanBakuId => $subtotal) {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        $supplierId = $bahanBaku->users->id;
        if (!isset($data_sub[$supplierId])) {
            $data_sub[$supplierId] = $subtotal;
        } else {
            $data_sub[$supplierId] += $subtotal;
>>>>>>> e3e05f7ae74cbe2470e0e6b98cc049316c247229
        }
    }

    $suplier = [];
    for($i=0; $i < count($request->bahan_baku); $i++){
        $bahan_baku = BahanBaku::findOrFail($request->bahan_baku[$i]);
        $suplier[] = $bahan_baku->users->id;
    }

    // Insert transaksi
    $uniqueSuppliers = array_unique($suplier);

    foreach ($uniqueSuppliers as $supplierId) {
        $transaksi = new Transaksi();
        $transaksi->tgl_pemesanan = date('Y-m-d');
        $transaksi->jumlah_bayar = 0;
        $transaksi->bukti_bayar = 0;
        $transaksi->keterangan = '-';
        $transaksi->total = $data_sub[$supplierId];
        $transaksi->save();

        // Insert detail transaksi berdasarkan bahan baku
        for ($i = 0; $i < count($request->bahan_baku); $i++) {
            $bahan_baku = BahanBaku::findOrFail($request->bahan_baku[$i]);
            if ($bahan_baku->users->id == $supplierId) {
                $detailTransaksi = new DetailTransaksi();
                $detailTransaksi->transaksi_id = $transaksi->id;
                $detailTransaksi->bahanbaku_id = $bahan_baku->id;
                $detailTransaksi->jumlah = $data_qty[$i]['quantity'];
                $detailTransaksi->save();
            }
        }
    }
<<<<<<< HEAD
=======
}

>>>>>>> e3e05f7ae74cbe2470e0e6b98cc049316c247229
}
