<?php

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
    return redirect(config('app.frontend_url', 'http://localhost:3000'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', EnsureIsEmployee::class])->get('/feed', function () {
    return redirect(config('app.frontend_url', 'http://localhost:3000'));
})->name('feed');
