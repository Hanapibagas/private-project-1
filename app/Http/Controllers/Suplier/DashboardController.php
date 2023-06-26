<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index_suplier()
    {
        $user = Auth::user();
        $users = Auth::id();
        $product = BahanBaku::where('user_id', $users)->count();
        $barangekeluar = BarangKeluar::whereHas('bahanBaku.users', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with('bahanBaku.users')
            ->count();
        // return response()->json($barangekeluar);
        return view('component.suplier.dashboard', compact('product', 'barangekeluar'));
    }
}
