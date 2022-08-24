<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('customer/dashboard', [CustomAuthController::class, 'dashboard']);
Route::get('customer/login', [CustomAuthController::class, 'index'])->name('customer.login');
Route::post('customer/custom-login', [CustomAuthController::class, 'customLogin'])->name('customer.customlogin');
Route::get('customer/registration', [CustomAuthController::class, 'registration'])->name('customer.register-customer');
Route::post('customer/custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.customer');
Route::get('customer/signout', [CustomAuthController::class, 'signOut'])->name('customer.signout');

