<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureIsEmployee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    if (auth()->user()->role->canAccessAdmin()) {
        return redirect('/admin');
    }
    return redirect('/feed');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', EnsureIsEmployee::class])->group(function () {
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
});
