<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function dashboard_admin()
    {
        return view('component.admin.dashboard');
    }
}
