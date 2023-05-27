<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function indexProduct()
    {
        $product = Product::all();
        return view('component.admin.product.index', compact('product'));
    }

    public function createProduct()
    {
        return view('component.admin.product.create');
    }

    public function storeProduct(ProductFormRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->file('foto')) {
            $file = $request->file('foto')->store('product-admin', 'public');
        }
        $validatedData['foto'] = $file;
        Product::create($validatedData);
        dd($validatedData);
        return redirect()->route('index-product')->with('status', 'Selamat data product berhasil ditambahkan');
    }

    public function editProduct($id)
    {
        $product = Product::where('id', $id)->first();
        return view('component.suplier.product.update', compact('product'));
    }

    public function updateProduct(ProductFormRequest $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $validatedData = $request->validated();
        if ($request->file('foto')) {
            $file = $request->file('foto')->store('product-admin', 'public');
            if ($product->foto && file_exists(storage_path('app/public/' . $product->foto))) {
                Storage::delete('public/' . $product->foto);
                $file = $request->file('foto')->store('product-admin', 'public');
            }
        }
        $validatedData['foto'] = $file;
        $product->update($validatedData);
        return redirect()->route('index-product')->with('status', 'Selamat data product berhasil diupdate');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)->first();
        $product->delete();
        return redirect()->route('index-product')->with('status', 'Selamat data product berhasil didelete');
    }
}
