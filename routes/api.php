<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() { return ['ok' => true]; });
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/deposit', [DepositController::class, 'deposit']);
    Route::post('/transfer', [TransferController::class, 'transfer']);
});
