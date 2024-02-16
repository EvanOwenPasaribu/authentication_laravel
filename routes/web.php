<?php

use App\Http\Controllers\auth\EmailVerificationController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::controller(OrderController::class)->group(function () {
//     Route::get('/orders/{id}', 'show');
//     Route::post('/orders', 'store');
// });

Route::get('/', [DashboardController::class, "index"])->name("dashboard");
Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/authenticate', [LoginController::class, "login"])->name("authenticate");
Route::get('/register', [RegisterController::class, "index"])->name('register');
Route::post('/store', [RegisterController::class, "register"])->name('store');
Route::post('/logout', [LoginController::class, "logout"])->name('logout');

Route::get('password/forgot', [ForgotPasswordController::class, "index"])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, "send"])->name('password.send');
Route::get('password/reset/{token}', [ResetPasswordController::class, "index"])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, "reset"])->name('reset');
Route::get('/email/verify', [EmailVerificationController::class, "index"])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, "verify"])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification',[EmailVerificationController::class, "sendVerification"])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', [UserController::class, "profile"])->middleware(['auth', 'verified'])->name('profile');

Route::get('auth/gmail', [LoginController::class, "redirectToGmail"])->name("login.gmail");
Route::get('auth/gmail/callback', [LoginController::class, "handleGmailCallback"])->name("gmail.callback");

Route::get('auth/register/gmail', [RegisterController::class, "redirectToGmail"])->name("register.gmail");