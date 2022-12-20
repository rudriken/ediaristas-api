<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Servico\ObtemServicos;
use App\Http\Controllers\Usuario\CadastroController;
use App\Http\Controllers\Endereco\BuscaCepApiExterna;
use App\Http\Controllers\Diarista\ObtemDiaristasPorCEP;
use App\Http\Controllers\Usuario\ResetarSenhaController;
use App\Http\Controllers\Diarista\VerificaDisponibilidade;

Route::get("/", IndexController::class);

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
Route::post("/recuperar-senha", [ResetarSenhaController::class, "solicitarToken"])
    ->name("usuarios.solicitar_alteracao_senha");
Route::post("/recuperar-senha/confirme", [ResetarSenhaController::class, "resetarSenha"])
    ->name("usuarios.alterar_senha");
