<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanKeluarController extends Controller
{
    public function getIndex()
    {
        $user = Auth::user();
        $bahankeluar = BarangKeluar::whereHas('bahanBaku.users', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with('bahanBaku.users')
            ->get();

        return view('component.suplier.barang-keluar.index', compact('bahankeluar'));
    }
}
