<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\LoginController::class , 'index'])->name('login');
Route::post('/login-submit', [\App\Http\Controllers\LoginController::class , 'submitLogin'])->name('submit-login');
Route::middleware([\Illuminate\Auth\Middleware\Authenticate::class])->group(function () {
   Route::get('/' , [\App\Http\Controllers\SchedulingController::class , 'index'])->name('home');
});
