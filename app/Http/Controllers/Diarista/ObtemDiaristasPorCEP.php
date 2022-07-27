<?php

namespace App\Http\Controllers\Diarista;

use App\Http\Requests\CepRequest;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterDiaristasPorCEP;
use App\Http\Resources\DiaristaPublicoCollection;

class ObtemDiaristasPorCEP extends Controller {
	private ObterDiaristasPorCEP $obterDiaristasPorCEP;

	public function __construct(ObterDiaristasPorCEP $ação) {
		$this->obterDiaristasPorCEP = $ação;
	}

	/**
	 * Busca diaristas pelo CEP
	 *
	 * @param CepRequest $request
	 * @return DiaristaPublicoCollection
	 */
    public function __invoke(CepRequest $request): DiaristaPublicoCollection {
		[$diaristas, $quantidadeDiaristas, $localidade] = 
			$this->obterDiaristasPorCEP->executar($request->cep);
		return new DiaristaPublicoCollection(
			$diaristas, $quantidadeDiaristas, $localidade
		);
    }
}
