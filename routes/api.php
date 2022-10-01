<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Diaria\PagaDiaria;
use App\Http\Controllers\Servico\ObtemServicos;
use App\Http\Controllers\Diaria\CadastroController as DiariaCadastroController;
use App\Http\Controllers\Usuario\CadastroController;
use App\Http\Controllers\Endereco\BuscaCepApiExterna;
use App\Http\Controllers\Diarista\ObtemDiaristasPorCEP;
use App\Http\Controllers\Usuario\AutenticacaoController;
use App\Http\Controllers\Diarista\VerificaDisponibilidade;

Route::get("/", IndexController::class);

Route::group(["middleware" => "auth:api"], function () {
    Route::get("/eu", [AutenticacaoController::class, "eu"])
        ->name("usuarios.show");
    Route::get("/diarias", [DiariaCadastroController::class, "index"])
        ->name("diarias.index");
    Route::post("/diarias", [DiariaCadastroController::class, "store"])
        ->name("diarias.store");
    Route::post("/diarias/{diaria}/pagamentos", PagaDiaria::class)->name("diarias.pagar");
});

/* ( . . . ) */
Route::get("/diaristas/localidades", ObtemDiaristasPorCEP::class)
    ->name("diaristas.busca_por_cep");
Route::get("/diaristas/disponibilidade", VerificaDisponibilidade::class)
    ->name("enderecos.disponibilidade");
Route::get("/enderecos", BuscaCepApiExterna::class)
    ->name("enderecos.cep");
Route::get("/servicos", ObtemServicos::class)
    ->name("servicos.index");
Route::post("/usuarios", [CadastroController::class, "store"])
    ->name("usuarios.create");
