<?php

namespace App\Http\Controllers\Suplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index_suplier()
    {
        return view('component.suplier.dashboard');
    }
}
