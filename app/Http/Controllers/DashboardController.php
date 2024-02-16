<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

}
