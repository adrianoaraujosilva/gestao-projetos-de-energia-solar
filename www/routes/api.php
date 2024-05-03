<?php

use App\Http\Controllers\IntegradorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\InstalacaoController;
use App\Http\Controllers\ProjetoController;
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
        });

    Route::prefix('instalacoes')
        ->name('instalacoes.')
        ->group(function () {
            Route::get('/', [InstalacaoController::class, 'index'])->name("index");
            Route::get('/{instalacao}', [InstalacaoController::class, 'show'])->name("show");
            Route::post('/', [InstalacaoController::class, 'store'])->name("store")->middleware('admin');
            Route::put('/{instalacao}', [InstalacaoController::class, 'update'])->name("update")->middleware('admin');
        });

    Route::prefix('equipamentos')
        ->name('equipamentos.')
        ->group(function () {
            Route::get('/', [EquipamentoController::class, 'index'])->name("index");
            Route::get('/{equipamento}', [EquipamentoController::class, 'show'])->name("show");
            Route::post('/', [EquipamentoController::class, 'store'])->name("store")->middleware('admin');
            Route::put('/{equipamento}', [EquipamentoController::class, 'update'])->name("update")->middleware('admin');
        });

    Route::prefix('projetos')
        ->name('projetos.')
        ->group(function () {
            Route::get('/', [ProjetoController::class, 'index'])->name("index");
            Route::get('/{projeto}', [ProjetoController::class, 'show'])->name("show");
            Route::post('/', [ProjetoController::class, 'store'])->name("store");
            Route::put('/{projeto}', [ProjetoController::class, 'update'])->name("update");
        });
});
