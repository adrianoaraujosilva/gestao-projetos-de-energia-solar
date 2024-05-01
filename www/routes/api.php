<?php

use App\Http\Controllers\IntegradorController;
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

Route::post('/auth/login', [IntegradorController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::middleware([
    'auth:sanctum',
    'active',
])->group(function () {

    Route::get('/integrador', fn (Request $request) => $request->user());

    Route::prefix('integradores')
        ->name('integradores.')
        ->middleware('admin')
        ->group(function () {
            Route::post('/', [IntegradorController::class, 'store'])->name('store');
            Route::get('/', [IntegradorController::class, 'index'])->name("index");
            Route::patch('/{integrador}/tipo', [IntegradorController::class, 'type'])->name('type');
            Route::patch('/{integrador}/desativar', [IntegradorController::class, 'deactive'])->name('deactive');
            Route::patch('/{integrador}/ativar', [IntegradorController::class, 'active'])->name('active');
        });
    Route::put('/integradores/{integrador}', [IntegradorController::class, 'update'])->name('integradores.update');

    Route::prefix('clientes')
        ->name('clientes.')
        ->group(function () {
            Route::get('/', [ClienteController::class, 'index'])->name("index");
            Route::post('/', [ClienteController::class, 'store'])->name("store");
            Route::get('/{cliente}', [ClienteController::class, 'show'])->name("show");
            Route::put('/{cliente}', [ClienteController::class, 'update'])->name("update");
        })->name("clientes.");
});
