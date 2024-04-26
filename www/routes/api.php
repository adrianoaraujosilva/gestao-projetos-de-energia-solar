<?php

use App\Http\Controllers\ClienteController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('clientes')
    ->name('clientes.')
    ->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name("index");
        Route::post('/', [ClienteController::class, 'store'])->name("store");
        Route::get('/{cliente}', [ClienteController::class, 'show'])->name("show");
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name("update");
    })->name("clientes.");
