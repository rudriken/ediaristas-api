<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Servico\ObtemServicos;
use App\Http\Controllers\Endereço\BuscaCepApiExterna;
use App\Http\Controllers\Diarista\ObtemDiaristasPorCEP;
use App\Http\Controllers\Diarista\VerificaDisponibilidade;

Route::get("/", IndexController::class);

Route::get("/diaristas/localidades", ObtemDiaristasPorCEP::class)
	->name("diaristas.busca_por_cep");
Route::get("/diaristas/disponibilidade", VerificaDisponibilidade::class)
	->name("endereços.disponibilidade");
Route::get("/enderecos", BuscaCepApiExterna::class)->name("endereços.cep");
Route::get("/servicos", ObtemServicos::class)->name("serviços.index");