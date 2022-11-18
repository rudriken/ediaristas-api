<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Diaria\PagaDiaria;
use App\Http\Controllers\Diaria\AvaliaDiaria;
use App\Http\Controllers\Diaria\Oportunidades;
use App\Http\Controllers\Servico\ObtemServicos;
use App\Http\Controllers\Diaria\ConfirmaPresenca;
use App\Http\Controllers\Diarista\DefineEndereco;
use App\Http\Controllers\Diaria\CandidataDiarista;
use App\Http\Controllers\Usuario\CadastroController;
use App\Http\Controllers\Endereco\BuscaCepApiExterna;
use App\Http\Controllers\Diarista\ObtemDiaristasPorCEP;
use App\Http\Controllers\Usuario\AutenticacaoController;
use App\Http\Controllers\Diarista\DefineCidadesAtendidas;
use App\Http\Controllers\Diarista\VerificaDisponibilidade;
use App\Http\Controllers\Diaria\CadastroController as DiariaCadastroController;

Route::get("/", IndexController::class);

Route::group(["middleware" => "auth:api"], function () {
    Route::get("/eu", [AutenticacaoController::class, "eu"])
        ->name("usuarios.show");
    Route::get("/diarias", [DiariaCadastroController::class, "index"])
        ->name("diarias.index");
    Route::post("/diarias", [DiariaCadastroController::class, "store"])
        ->name("diarias.store");
    Route::get("/diarias/{diaria}", [DiariaCadastroController::class, "show"])
        ->name("diarias.show");
    Route::put("/usuarios/endereco", DefineEndereco::class)
        ->name("usuarios.definir-endereco");
    Route::put("/usuarios/cidades-atendidas", DefineCidadesAtendidas::class)
        ->name("usuarios.definir-cidades");
    Route::post("/diarias/{diaria}/pagamentos", PagaDiaria::class)->name("diarias.pagar");
    Route::post("/diarias/{diaria}/candidatos", CandidataDiarista::class)
        ->name("diarias.candidatar");
    Route::get("/oportunidades", Oportunidades::class)->name("oportunidades.index");
    Route::patch("/diarias/{diaria}/presenca", ConfirmaPresenca::class)
        ->name("diarias.confirmar");
    Route::patch("/diarias/{diaria}/avaliacoes", AvaliaDiaria::class)
        ->name("diarias.avaliar");
});

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
