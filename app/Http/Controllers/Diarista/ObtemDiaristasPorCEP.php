<?php

namespace App\Http\Controllers\Diarista;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiaristaPublicoCollection;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;
use Illuminate\Validation\ValidationException;

class ObtemDiaristasPorCEP extends Controller {
	/**
	 * Busca diaristas pelo CEP
	 *
	 * @param Request $request
	 * @param InterfaceConsultaCEP $serviçoCEP
	 * @return DiaristaPublicoCollection|JsonResponse
	 */
    public function __invoke(
		Request $request, 
		InterfaceConsultaCEP $serviçoCEP
	): DiaristaPublicoCollection | JsonResponse {
		$request->validate([
			"cep" => ["required", "numeric"],
		]);
		$dados = $serviçoCEP->buscar($request->cep);
		if ($dados === false) { 
			throw ValidationException::withMessages(
				["cep" => "CEP inválido ou não encontrado"]
			);
		}
        $diaristas = User::diaristasDisponívelCidade($dados->ibge);
        $quantidadeDiaristas = User::diaristasDisponívelCidadeQuantidade($dados->ibge);
		return new DiaristaPublicoCollection(
			$diaristas, $quantidadeDiaristas, $dados->localidade
		);
    }
}
