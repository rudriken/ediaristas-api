<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Diaria\PagaDiaria;
use App\Http\Controllers\Servico\ObtemServicos;
use App\Http\Controllers\Diaria\CadastroController as DiariaCadastroController;
use App\Http\Controllers\Usuário\CadastroController;
use App\Http\Controllers\Endereço\BuscaCepApiExterna;
use App\Http\Controllers\Diarista\ObtemDiaristasPorCEP;
use App\Http\Controllers\Usuário\AutenticacaoController;
use App\Http\Controllers\Diarista\VerificaDisponibilidade;

Route::get("/", IndexController::class);

Route::group(["middleware" => "auth:api"], function () {
    Route::get("/eu", [AutenticacaoController::class, "eu"])
        ->name("usuários.show");
    Route::post("/diarias", [DiariaCadastroController::class, "store"])
        ->name("diárias.store");
    Route::post("/diarias/{diaria}/pagamentos", PagaDiaria::class)->name("diarias.pagar");
});


Route::get("/diaristas/localidades", ObtemDiaristasPorCEP::class)
    ->name("diaristas.busca_por_cep");
Route::get("/diaristas/disponibilidade", VerificaDisponibilidade::class)
    ->name("endereços.disponibilidade");
Route::get("/enderecos", BuscaCepApiExterna::class)
    ->name("endereços.cep");
Route::get("/servicos", ObtemServicos::class)
    ->name("serviços.index");
Route::post("/usuarios", [CadastroController::class, "store"])
    ->name("usuários.create");
