<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BahanBakuController extends Controller
{
    public function index_bahan_baku_suplier()
    {
        $bahanbaku = BahanBaku::all();
        return view('component.suplier.bahan-baku.index', compact('bahanbaku'));
    }

    public function create_bahan_baku_suplier()
    {
        return view('component.suplier.bahan-baku.create');
    }

    public function store_bahan_baku_suplier(Request $request)
    {
        $user = Auth::id();
        $message = [
            'required' => 'Mohon maaf anda lupa untuk mengisi ini dan harap anda mangisi terlebih dahulu'
        ];

        $this->validate($request, [
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'satuan' => 'required',
        ], $message);

        if ($request->file('gambar')) {
            $file = $request->file('gambar')->store('bahan-baku-suplier', 'public');
        }
        BahanBaku::create([
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'satuan' => $request->input('satuan'),
            'gambar' => $file,
            'user_id' => $user,
        ]);

        return redirect()->route('index_bahan_baku_suplier')->with('status', 'Selamat data bahan baku berhasil ditambahkan');
    }

    public function edit_bahan_baku_suplier(Request $request, $id)
    {
        $bahanbaku = BahanBaku::where('id', $id)->first();
        return view('component.suplier.bahan-baku.update', compact('bahanbaku'));
    }

    public function update_bahan_baku_suplier(Request $request, $id)
    {
        $bahanbaku = BahanBaku::where('id', $id)->first();
        $user = Auth::id();

        if ($request->file('gambar')) {
            $file = $request->file('gambar')('bahan-baku-suplier', 'public');
            if ($bahanbaku->gambar && file_exists(storage_path('app/public/' . $bahanbaku->gambar))) {
                Storage::delete('public/' . $bahanbaku->gambar);
                $file = $request->file('gambar')('bahan-baku-suplier', 'public');
            }
        }

        if ($request->file('gambar') === null) {
            $file = $bahanbaku->gambar;
        }

        $bahanbaku->update([
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'satuan' => $request->input('satuan'),
            'gambar' => $file,
            'user_id' => $user,
        ]);

        return redirect()->route('index_bahan_baku_suplier')->with('status', 'Selamat data bahan baku berhasil diperbarui');
    }

    public function destroy_bahan_baku_suplier($id)
    {
        $delete = BahanBaku::where('id', $id)->first();
        if ($delete->gambar && file_exists(storage_path('app/public/' . $delete->gambar))) {
            Storage::delete('public/' . $delete->gambar);
        }

        $delete->delete();
        return response()->json(['status' => 'Selamat data bahan baku berhasil dihapus']);
    }
}
