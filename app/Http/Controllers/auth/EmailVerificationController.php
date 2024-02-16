<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view("auth.verifyEmail");
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/');
    }

    public function sendVerification (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    }
}
