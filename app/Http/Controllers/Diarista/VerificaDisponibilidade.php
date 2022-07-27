<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterDiaristasPorCEP;

class VerificaDisponibilidade extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ObterDiaristasPorCEP $ação): JsonResponse {
		$request->validate([
			"cep" => ["required", "numeric"],
		]);
		[$diaristas] = $ação->executar($request->cep);
		return resposta_padrão(
			200, 
			"sucesso", 
			"Disponiblidade verificada com sucesso", 
			["disponibilidade" => $diaristas->isNotEmpty()]
		); // "isNotEmpty" é um método da própria Collection do Laravel
    }
}
