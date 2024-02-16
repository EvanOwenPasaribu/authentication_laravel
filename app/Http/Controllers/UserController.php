<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        if (Auth::check()) {
            return view('profile');
        }

        return redirect()->route('login')
            ->withErrors([
                'status' => 'Please login.',
            ]);
    }
}
