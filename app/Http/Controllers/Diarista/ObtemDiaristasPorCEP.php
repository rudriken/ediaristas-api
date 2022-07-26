<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\ObterDiaristasPorCEP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiaristaPublicoCollection;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;


class ObtemDiaristasPorCEP extends Controller {
	/**
	 * Busca diaristas pelo CEP
	 *
	 * @param Request $request
	 * @param InterfaceConsultaCEP $serviçoCEP
	 * @return DiaristaPublicoCollection
	 */
    public function __invoke(
		Request $request, ObterDiaristasPorCEP $ação
	): DiaristaPublicoCollection {
		$request->validate([
			"cep" => ["required", "numeric"],
		]);
		[$diaristas, $quantidadeDiaristas, $localidade] = $ação->executar($request->cep);
		return new DiaristaPublicoCollection(
			$diaristas, $quantidadeDiaristas, $localidade
		);
    }
}
