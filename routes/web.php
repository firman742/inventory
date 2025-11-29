<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Internal\ProductController;
use App\Http\Controllers\Internal\ProductTypeController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Contoh halaman setelah login
Route::get('/dashboard', function () {
    if (!session()->has('user')) {
        return redirect('/login')->with('error', 'Harap login dulu');
    }
    return view('Internal.dashboard');
})->name('dashboard');

Route::middleware(['session.auth'])->group(function () {
    Route::get('/profile', function () {
        return view('Internal.profile');
    })->name('profile.show');


    // Product Type Routes
    Route::resource('product-types', ProductTypeController::class);
    // Product Routes
    Route::resource('products', ProductController::class);
});