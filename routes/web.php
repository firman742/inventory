<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Internal\ProductController;
use App\Http\Controllers\Internal\StockOutController;
use App\Http\Controllers\Internal\ProductTypeController;
use App\Http\Controllers\Internal\StockInBatchController;

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
    // Stock In Batch Routes
    Route::resource('stock-in', StockInBatchController::class);

    Route::get('stock-in/{stock_in}/serials', [StockInBatchController::class, 'serials'])->name('stock-in.serials.show');
    Route::post('stock-in/{stock_in}/serials', [StockInBatchController::class, 'storeSerial'])
        ->name('stock-in.serials.store');

    // Stock Out Routes
    // Custom routes HARUS ditempatkan SEBELUM resource untuk menghindari konflik
    Route::post('stock-out/validate-scan', [StockOutController::class, 'validateScan'])->name('stock-out.validateScan');
    Route::get('stock-out/confirm-create', [StockOutController::class, 'confirmCreate'])->name('stock-out.confirmCreate');
    // Resource routes (akan membuat stock-out.index, stock-out.create, dll.)
    Route::resource('stock-out', StockOutController::class);
});
