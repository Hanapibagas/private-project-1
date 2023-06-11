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
    public function getBahanBaku(){
        $data = BahanBaku::where('stok','>',0)->simplePaginate(12);
        return view('component.admin.transaksi.bahanbaku',compact('data'));
    }

    public function getCart(){
        $data = Cart::all();
        return view('component.admin.transaksi.cart',compact('data'));
    }

    public function storeCart(Request $request){
        $duplicate = Cart::where('bahanbaku_id',$request->bahan_baku)->first();

        if($duplicate)
        {
            return redirect()->back()->with('warning','Item sudah ada dalam keranjang');
        }

        $data = new Cart();
        $data->bahanbaku_id = $request->bahan_baku;
        $data->jumlah = 1;
        $data->save();

        return redirect()->back()->with('status', 'Berhasil menambah item ke keranjang');
    }

    public function deleteCart($id){
        $data = Cart::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus item di keranjang');
    }



    public function checkout(Request $request){

    $bahanBakuIds = $request->input('bahan_baku');
    $quantities = $request->input('quantity');
    $total = $request->input('subtotal');

    dd($total);

    $selectedItems = [];
    foreach ($bahanBakuIds as $bahanBakuId) {
        if (isset($quantities[$bahanBakuId])) {
            $selectedItems[$bahanBakuId] = $quantities[$bahanBakuId];
        }
    }

    $data = [];
    foreach ($selectedItems as $bahanBakuId => $quantity) {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        $data[] = ['bahan_baku' => $bahanBakuId , 'quantity' => $quantity];
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
            $transaksi->keterangan = '';
            $transaksi->total = $total;
            $transaksi->save();

            // Insert detail transaksi berdasarkan bahan baku
            for ($i = 0; $i < count($request->bahan_baku); $i++) {
                $bahan_baku = BahanBaku::findOrFail($request->bahan_baku[$i]);
                if ($bahan_baku->users->id == $supplierId) {
                    $detailTransaksi = new DetailTransaksi();
                    $detailTransaksi->transaksi_id = $transaksi->id;
                    $detailTransaksi->bahanbaku_id = $bahan_baku->id;
                    $detailTransaksi->jumlah = $data[$i]['quantity'];
                    $detailTransaksi->save();
                }
            }
        }


    }



}
