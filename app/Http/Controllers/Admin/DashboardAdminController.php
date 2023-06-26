<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function dashboard_admin()
    {
        $pending = Transaksi::where('status', 'proses')->count();
        $selesai = Transaksi::where('status', 'selesai')->count();
        $barangmasuk = BarangMasuk::count();
        return view('component.admin.dashboard', compact('pending', 'selesai', 'barangmasuk'));
    }
}
