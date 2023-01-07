<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

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
Route::get('userlist', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('userlist/{id}', [UserController::class, 'show'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','hasrole:admin'])->group(function () {
    Route::put('userlist/{id}', [UserController::class, 'update']);
    Route::delete('userlist/{id}', [UserController::class, 'destroy']);
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
Route::delete('logout', [LoginController::class, 'logout']);

Route::get('siswa', [SiswaController::class, 'index'])->middleware('auth:sanctum');
Route::get('siswa/{id}', [SiswaController::class, 'show'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','hasrole:admin'])->group(function () {
    Route::post('siswa', [SiswaController::class, 'store']);
    Route::put('siswa/{id}', [SiswaController::class, 'update']);
    Route::delete('siswa/{id}', [SiswaController::class, 'destroy']);
});
