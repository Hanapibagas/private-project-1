<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardGudangController extends Controller
{
    public function dashboard_gudang()
    {
        return view('component.gudang.dashboard');
    }
}
