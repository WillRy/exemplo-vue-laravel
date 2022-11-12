<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return \Inertia\Inertia::render("Teste");
});

/**
 * Rotas publicas
 */
Route::group(['middleware' => 'guest'], function () {
    Route::get("/login", [LoginController::class, 'login'])->name("login");
    Route::post("/logar", [LoginController::class, 'logar'])->name("logar");

    Route::get("/cadastro", [LoginController::class, 'cadastro'])->name("auth.cadastro");
    Route::post("/cadastrar", [LoginController::class, 'cadastrar'])->name("auth.cadastrar");
    Route::get("/logout", [LoginController::class, 'logout'])->name("logout");
});

/**
 * Rotas privadas
 */

Route::group(['middleware' => 'auth:usuarios'], function () {

    Route::get("/", [DashboardController::class, 'index'])->name("dashboard");

    Route::group(['prefix' => 'empresas'], function () {
        Route::get("/", [\App\Http\Controllers\EmpresaController::class, 'index'])->name("empresas");
        Route::get("/listar", [\App\Http\Controllers\EmpresaController::class, 'listar'])->name("empresas.listar");
        Route::post("/cadastrar", [\App\Http\Controllers\EmpresaController::class, 'cadastrar'])->name("empresas.cadastrar");
        Route::post("/editar/{id}", [\App\Http\Controllers\EmpresaController::class, 'editar'])->name("empresas.editar");
        Route::post("/excluir/{id}", [\App\Http\Controllers\EmpresaController::class, 'excluir'])->name("empresas.excluir");
        Route::get("/detalhes/{id}", [\App\Http\Controllers\EmpresaController::class, 'detalhes'])->name("empresas.detalhes");
    });

});
