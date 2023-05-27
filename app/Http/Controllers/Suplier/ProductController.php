<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index_product_suplier()
    {
        $suplier = Product::all();
        return view('component.suplier.product.index', compact('suplier'));
    }

    public function create_product_suplier()
    {
        return view('component.suplier.product.create');
    }

    public function store_product_suplier(Request $request)
    {
        $message = [
            'required' => 'Mohon maaf anda lupa untuk mengisi ini dan harap anda mangisi terlebih dahulu'
        ];

        $this->validate($request, [
            'nama' => 'required',
            'harga' => 'required',
            'satuan' => 'required',
        ], $message);

        if ($request->file('foto')) {
            $file = $request->file('foto')->store('product-suplier', 'public');
        }

        Product::create([
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'satuan' => $request->input('satuan'),
            'foto' => $file,
        ]);

        return redirect()->route('index_product_suplier')->with('status', 'Selamat data product berhasil ditambahkan');
    }

    public function edit_product_suplier(Request $request, $id)
    {
        $suplier = Product::where('id', $id)->first();
        return view('component.suplier.product.update', compact('suplier'));
    }

    public function update_product_suplier(Request $request, $id)
    {
        $suplier = Product::where('id', $id)->first();

        if ($request->file('foto')) {
            $file = $request->file('foto')->store('product-suplier', 'public');
            if ($suplier->foto && file_exists(storage_path('app/public/' . $suplier->foto))) {
                Storage::delete('public/' . $suplier->foto);
                $file = $request->file('foto')->store('product-suplier', 'public');
            }
        }

        if ($request->file('foto') === null) {
            $file = $suplier->foto;
        }

        $suplier->update([
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'satuan' => $request->input('satuan'),
            'foto' => $file,
        ]);

        return redirect()->route('index_product_suplier')->with('status', 'Selamat data product berhasil diperbarui');
    }

    public function destroy_prodcut_suplier($id)
    {
        $suplier = Product::find($id);

        if ($suplier->foto && file_exists(storage_path('app/public/' . $suplier->foto))) {
            Storage::delete('public/' . $suplier->foto);
        }

        $suplier->delete();

        return response()->json(['status' => 'Selamat data infografis berhasil dihapus']);
    }
}
