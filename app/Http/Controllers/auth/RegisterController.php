<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\RegisterType;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'username' => 'required|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ], [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than :max characters.',
            'username.required' => 'The username field is required.',
            'username.unique' => 'The username has already been taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :min characters.',
            'password.confirmed' => 'The password confirmation does not match.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('login')
        ->withSuccess('You have successfully registered & logged in!');
    }

    public function redirectToGmail()
    {
        session(['method_gmail' => 'register']);
        return Socialite::driver('google')
            ->redirect();
    }


}
