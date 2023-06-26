<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukAdminController extends Controller
{
    public function getIndex()
    {
        $data = BarangMasuk::all();
        return view('component.admin.barang-masuk.index', compact('data'));
    }
}
