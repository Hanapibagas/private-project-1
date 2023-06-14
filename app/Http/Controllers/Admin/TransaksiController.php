<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\User;
use PDF;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function getTransaksi(){
        $data = Transaksi::orderBy('created_at','desc')->simplePaginate(5);
        return view('component.admin.transaksi.list_transaksi',compact('data'));
    }

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
        $subtotals = $request->input('subtotal');
        $carts = $request->input('cart_id');

        $selectedItems_qty = [];
        $selectedItems_sub = [];
        $selectedItems_cart = [];
        foreach ($bahanBakuIds as $bahanBakuId) {
            if (isset($quantities[$bahanBakuId])) {
                $selectedItems_qty[$bahanBakuId] = $quantities[$bahanBakuId];
            }
            if (isset($subtotals[$bahanBakuId])) {
                $selectedItems_sub[$bahanBakuId] = $subtotals[$bahanBakuId];
            }
            if (isset($carts[$bahanBakuId])) {
                $selectedItems_cart[$bahanBakuId] = $carts[$bahanBakuId];
            }
        }


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
        foreach($selectedItems_cart as $cart_id){
            $cart = Cart::findOrFail($cart_id);
            $cart->delete();
        }

        return redirect()->route('get.transaksi')->with('status', 'Silahkan lakukan pembayaran');
}


public function payment(Request $request){
    $validatedData = $request->validate([
        'bukti_bayar' => 'required',
        'jumlah_bayar' => 'required'
    ]);
    if ($request->file('bukti_bayar')) {
        $file = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
    }
    $id = $request->id;
    $transaksi = Transaksi::findOrFail($id);
    $transaksi->jumlah_bayar = $request->jumlah_bayar;
    $transaksi->bukti_bayar = $file;
    $transaksi->save();
    return redirect()->back()->with('status', 'Berhasil lakukan pembayaran');
}

public function getBuktiBayar($id){
    $data = Transaksi::findOrFail($id);
    return response()->json($data);
}

public function printNota($id){
    $data = DetailTransaksi::where('transaksi_id',$id)->get();
    $total = Transaksi::select('total')->findOrFail($id);
    $pdf = PDF::loadView('component.admin.transaksi.nota_pdf',compact('data','total'));
    return $pdf->stream();
}

}
