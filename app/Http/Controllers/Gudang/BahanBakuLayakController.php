<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\ProductLayak;
use Illuminate\Http\Request;

class BahanBakuLayakController extends Controller
{
    public function getIndex()
    {
        $layak = ProductLayak::orderBy('created_at', 'desc')->get();

        return view('component.gudang.layak-produksi.index', compact('layak'));
    }

    public function getCreate()
    {
        return view('component.gudang.layak-produksi.create');
    }

    public function getStore(Request $request)
    {
        ProductLayak::create([
            'nama_product' => $request->input('nama_product'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('get.IndexLayakProduksi')->with('status', 'Selamat data product expired berhasil ditambahkan');
    }

    public function getUpdate(Request $request, $id)
    {
        $layak = ProductLayak::where('id', $id)->first();

        $layak->update([
            'nama_product' => $request->input('nama_product'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('get.IndexLayakProduksi')->with('status', 'Selamat data product expired berhasil diperbarui');
    }

    public function getDestroy($id)
    {
        $layak = ProductLayak::findOrFail($id);

        $layak->delete();

        return redirect()->back()->with('status', 'Data berita berhasil dihapus');
    }
}
