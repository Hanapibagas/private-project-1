<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLayak;
use Illuminate\Http\Request;

class laporanController extends Controller
{
    public function getIndex()
    {
        $layak = ProductLayak::orderBy('created_at', 'desc')->get();

        return view('component.admin.laporan.index', compact('layak'));
    }
}
