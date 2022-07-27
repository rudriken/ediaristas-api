<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterDiaristasPorCEP;
use App\Http\Resources\DiaristaPublicoCollection;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;


class ObtemDiaristasPorCEP extends Controller {
	private ObterDiaristasPorCEP $obterDiaristasPorCEP;

	public function __construct(ObterDiaristasPorCEP $ação) {
		$this->obterDiaristasPorCEP = $ação;
	}

	/**
	 * Busca diaristas pelo CEP
	 *
	 * @param Request $request
	 * @param InterfaceConsultaCEP $serviçoCEP
	 * @return DiaristaPublicoCollection
	 */
    public function __invoke(Request $request): DiaristaPublicoCollection {
		$request->validate([
			"cep" => ["required", "numeric"],
		]);
		[$diaristas, $quantidadeDiaristas, $localidade] = 
			$this->obterDiaristasPorCEP->executar($request->cep);
		return new DiaristaPublicoCollection(
			$diaristas, $quantidadeDiaristas, $localidade
		);
    }
}
