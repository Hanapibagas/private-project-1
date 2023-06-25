<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BahanKeluarController extends Controller
{
    public function getIndex()
    {
        $bahankeluar = BarangKeluar::all();
        return view('component.suplier.barang-keluar.index', compact('bahankeluar'));
    }
}
