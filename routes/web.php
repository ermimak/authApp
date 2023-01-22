<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class,'login'])->name('login');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');

Route::post('/login', [RegistrationController::class,'register'])->name('register');

Route::middleware(['auth', 'CheckRole'])->group(function () {
    Route::get('/admin', [AdminController::class,'admin']);
});

Route::post('/password/email', [Auth\ForgotPasswordController::class,'sendResetLinkEmail'])
                                ->name('password.email');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/store', [HomeController::class, 'store'])->name('store');
Route::get('/home/edit/{info}', [HomeController::class, 'edit'])->name('edit');
Route::get('/home/view/{info}', [HomeController::class, 'view'])->name('view');
Route::get('/home/{info}', [HomeController::class, 'destroy'])->name('destroy');


Route::get('two-factor-authentication', [TwoFactorAuthController::class, 'index'])->name('check2fa.index');
Route::post('two-factor-authentication', [TwoFactorAuthController::class, 'store'])->name('check2fa.store');
Route::get('two-factor-authentication/resend', [TwoFactorAuthController::class, 'resend'])->name('check2fa.resend');
