<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return response()->json([
        'status' => 200,
        'message' => "Success",
        'data' => $request->user()
    ], 200);
});

Route::post('/login', [AuthController::class, "login"])->name("login");
Route::post('/register', [AuthController::class, "register"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/barang', [BarangController::class, "search"]);
    Route::post('/checkout', [TransaksiController::class, "storeTransaksi"]);
    Route::post('/logout', [AuthController::class, "logout"]);
});

Route::get('/unauthorized', function () {
    return response()->json([
        'status' => 401,
        'message' => "Unauthorized",
        'data' => []
    ], 401);
})->name("unauthorized");
