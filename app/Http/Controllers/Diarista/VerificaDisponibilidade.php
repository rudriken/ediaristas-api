<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\CepRequest;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterDiaristasPorCEP;

class VerificaDisponibilidade extends Controller {
	private ObterDiaristasPorCEP $obterDiaristasPorCEP;

	public function __construct(ObterDiaristasPorCEP $acao) {
		$this->obterDiaristasPorCEP = $acao;
	}

	/**
	 * Retorna a disponibilidade de diaristas para um CEP
	 *
	 * @param CepRequest $request
	 * @return JsonResponse
	 */
    public function __invoke(CepRequest $request): JsonResponse {
		[$diaristas] = $this->obterDiaristasPorCEP->executar($request->cep);
		return resposta_padrao(
			200,
			"sucesso",
			"Disponiblidade verificada com sucesso",
			["disponibilidade" => $diaristas->isNotEmpty()]
		);
    }
}
