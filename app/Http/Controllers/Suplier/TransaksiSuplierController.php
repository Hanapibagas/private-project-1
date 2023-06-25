<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiSuplierController extends Controller
{
    public function getTransaksi()
    {
        $user = Auth::user();
        $data = Transaksi::whereHas('detailTransaksi.bahanBaku.users', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with('detailTransaksi.bahanBaku.users')
            ->simplePaginate(5);

        return view('component.suplier.transaksi.index', compact('data'));
    }

    public function getDetails(Request $request, $id)
    {
        // $user = Auth::user();
        $data = Transaksi::where('id', $id)->first();

        $data->update([
            'status' => $request->input('status')
        ]);

        

        // dd($data);
        // return view('component.suplier.transaksi.index', compact('data'));
    }
}
