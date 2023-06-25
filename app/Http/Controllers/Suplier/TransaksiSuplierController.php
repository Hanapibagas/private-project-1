<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiSuplierController extends Controller
{
    public function getTransaksi()
    {
        $user = Auth::user();
        $data = Transaksi::whereHas('detailTransaksi.bahanBaku.users', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with('detailTransaksi.bahanBaku.users')
            ->simplePaginate(5);

        return view('component.suplier.transaksi.index', compact('data'));
    }

    public function getDetails(Request $request, $id)
    {
        $bahan_baku_id = $request->input('bahan_baku_id');
        $jumlah = $request->input('jumlah');


        $data = Transaksi::where('id', $id)
            ->first();

        $data->update([
            'status' => $request->input('status'),
            'keterangan' => $request->input('keterangan')
        ]);

        for ($i = 0; $i < count($bahan_baku_id); $i++) {
            $id = $bahan_baku_id[$i];
            $qty = $jumlah[$i];

            $bahanBaku = BahanBaku::find($id);
            $stok = $bahanBaku->stok - $qty;
            $bahanBaku->stok = $stok;
            $bahanBaku->save();

            BarangKeluar::create([
                'tanggal' => date('Y-m-d'),
                'total' => $qty,
                'bahanbaku_id' => $bahanBaku->id,
                'transaksi_id' => $data->id
            ]);

            BarangMasuk::create([
                'tanggal' => date('Y-m-d'),
                'total' => $qty,
                'bahanbaku_id' => $bahanBaku->id,
                'transaksi_id' => $data->id
            ]);
        }

        // return view('component.suplier.transaksi.index', compact('data'));
    }
}
