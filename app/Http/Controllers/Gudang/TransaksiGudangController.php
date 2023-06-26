<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use PDF;
use Illuminate\Http\Request;

class TransaksiGudangController extends Controller
{
    public function getIndex()
    {
        $data = Transaksi::all();

        return view('component.gudang.transaksi.index', compact('data'));
    }

    public function getPrintToPDF()
    {
        $data = Transaksi::all();

        view()->share('rekap', $data);

        $pdf = PDF::loadview('component.gudang.transaksi.rekap-pdf', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('rekap.pdf');
    }
}
