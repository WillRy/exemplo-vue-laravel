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
});
