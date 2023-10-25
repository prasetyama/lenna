<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('logger')->post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::middleware('logger')->post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('logger')->post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

Route::middleware(['auth:auth', 'logger'])->get('/messages', [ChatController::class, 'index'])->name('index');
Route::middleware(['auth:auth', 'logger'])->post('/messages', [ChatController::class, 'sendMessage'])->name('sendMessage');
