<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\BarangExpired;
use App\Models\Product;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function getIndex()
    {
        $expired = BarangExpired::orderBy('created_at', 'desc')->get();

        return view('component.gudang.product.index', compact('expired'));
    }

    public function getStore(Request $request)
    {
        BarangExpired::create([
            'nama' => $request->input('nama'),
            'total' => $request->input('total'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('get.IndexProduct')->with('status', 'Selamat data product expired berhasil ditambahkan');
    }

    public function getUpdate(Request $request, $id)
    {
        $expired = BarangExpired::where('id', $id)->first();

        $expired->update([
            'nama' => $request->input('nama'),
            'total' => $request->input('total'),
            'jumlah' => $request->input('jumlah'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('get.IndexProduct')->with('status', 'Selamat data product expired berhasil diperbarui');
    }

    public function getDestroy($id)
    {
        $expired = BarangExpired::findOrFail($id);

        $expired->delete();

        return redirect()->back()->with('status', 'Data berita berhasil dihapus');
    }
}
