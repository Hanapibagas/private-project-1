<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangExpired;
use App\Models\ProductLayak;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class laporanController extends Controller
{
    public function getIndex()
    {
        $layak = BarangExpired::orderBy('created_at', 'desc')->get();
        $transaksi = Transaksi::all();

        return view('component.admin.laporan.index', compact('layak', 'transaksi'));
    }
}
