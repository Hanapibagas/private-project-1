<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo;
    public function redirectTo()
    {
        switch (Auth::user()->role) {
            case "suplier";
                $this->redirectTo = '/dashboard-suplier';
                return $this->redirectTo;
                break;
            case "admin";
                $this->redirectTo = '/dashboard-admin';
                return $this->redirectTo;
                break;
            case "gudang";
                $this->redirectTo = '/dashboard-gudang';
                return $this->redirectTo;
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
