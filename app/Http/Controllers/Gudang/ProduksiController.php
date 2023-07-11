<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function getIndex()
    {
        $product = Product::all();
        return view('component.gudang.product.index', compact('product'));
    }
}
