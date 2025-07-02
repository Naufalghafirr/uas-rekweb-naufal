<?php

use App\Http\Controllers\{ProductController, UserController};
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login', ['title' => 'Login']);
})->name('root');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login', ['title' => 'Login']);
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('loginUser');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/get/{product}', [ProductController::class, 'getProduct'])->name('products.get');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/export-pdf', [ProductController::class, 'exportPDF'])->name('products.export');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/get/{user}', [UserController::class, 'getUser'])->name('users.get');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export-pdf', [UserController::class, 'exportPDF'])->name('users.export-pdf');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});