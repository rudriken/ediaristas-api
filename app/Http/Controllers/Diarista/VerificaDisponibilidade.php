<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterDiaristasPorCEP;

class VerificaDisponibilidade extends Controller {
	private ObterDiaristasPorCEP $obterDiaristasPorCEP;

	public function __construct(ObterDiaristasPorCEP $ação) {
		$this->obterDiaristasPorCEP = $ação;
	}

	/**
	 * Retorna a disponibilidade de diaristas para um CEP
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
    public function __invoke(Request $request): JsonResponse {
		$request->validate([
			"cep" => ["required", "numeric"],
		]);
		[$diaristas] = $this->obterDiaristasPorCEP->executar($request->cep);
		return resposta_padrão(
			200, 
			"sucesso", 
			"Disponiblidade verificada com sucesso", 
			["disponibilidade" => $diaristas->isNotEmpty()]
		);
    }
}
