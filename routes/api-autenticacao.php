<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuário\AutenticacaoController;

Route::post("/token", [AutenticacaoController::class, "login"])
    ->name("autenticação.login");
Route::post("/logout", [AutenticacaoController::class, "logout"])
    ->middleware("auth:api")
    ->name("autenticação.logout");
Route::post("/token/atualizar", [AutenticacaoController::class, "atualizar"])
    ->name("autenticação.atualizar");
