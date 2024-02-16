<?php

namespace App\Http\Controllers\auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\RegisterType;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except("logout");
        parent::__construct();
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $login_setting = json_decode($this->getValueSetting("login"), true);
        $maxAttempts = $login_setting['max_attempt'];
        $decayMinutes = $login_setting['delay_attempt'];

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Invalid email format.',
            'password.required' => 'Please enter your password.',
        ]);

        $email = $request['email'];

        $attempts = Cache::get('login_attempts_' . $email, 0);
        if ($attempts >= $maxAttempts) {
            return back()->withErrors(['error' => 'Too many login attempts. Please try again later in 1 minute.']);
        }

        $user = User::where("email", $email)->first();

        if ($user && $user->registerType->name != 'normal') {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Invalid login credentials.',
                ])->withStatus(422);
        }

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            Cache::forget('login_attempts_' . $email);
            $request->session()->regenerate();
            return redirect()->route('login')
                ->withSuccess('You have successfully logged in!');
        }

        $attempts = Cache::get('login_attempts_' . $email, 0);
        $attempts++;
        Cache::put('login_attempts_' . $email, $attempts, $decayMinutes);
        if ($attempts >= $maxAttempts) {
            Log::channel('custom-log')->error("$email : Trying login too much");
            return back()->withErrors(['error' => 'Too many login attempts. Please try again later in 1 minute.']);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Invalid login credentials.',
            ]);
    }

    public function redirectToGmail()
    {
        session(['method_gmail' => 'login']);
        return Socialite::driver('google')
            ->redirect();
    }

    public function handleGmailCallback()
    {
        $action = session('method_gmail');

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();
            $registerType = RegisterType::where("name", "google")->first();

            if (!$registerType) {
                return redirect()->route($action)->withErrors(['error' => 'Authenticate with Google is Maintenance']);
            }

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'username' => $googleUser->email,
                    'email' => $googleUser->email,
                    'id_register_type' => $registerType->id,
                    'email_verified_at' => date('Y-m-d H:i:s')
                ]);
                event(new Registered($user));
            } else {
                if ($action == "register") {
                    return redirect()->route($action)->withErrors(['error' => 'Your email has been registered']);
                } else if ($user->registerType->name == 'normal') {
                    return redirect()->route($action)->withErrors(['error' => 'Your account not using this type of login, please enter your email and password']);
                }
            }
            Auth::login($user);
            return redirect()->route('login')
                ->withSuccess('You have successfully logged in!');
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('login')->withErrors(['error' => 'Unable to authenticate with Google.' . $errorMessage]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withSuccess('You have logged out successfully!');
    }
}
