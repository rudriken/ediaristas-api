<?php

namespace App\Actions\Diarista;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class ObterDiaristasPorCEP {
	private InterfaceConsultaCEP $serviçoCEP;

	public function __construct(InterfaceConsultaCEP $ação) {
		$this->serviçoCEP = $ação;
	}

	/**
	 * Busca diaristas a partir de um CEP
	 *
	 * @param string $cep
	 * @return array
	 */
	public function executar(string $cep): array {
		$dados = $this->serviçoCEP->buscar($cep);
		if ($dados === false) { 
			throw ValidationException::withMessages(
				["cep" => "CEP inválido ou não encontrado"]
			);
		}
		$diaristas = User::diaristasDisponívelCidade($dados->ibge);
        $quantidadeDiaristas = User::diaristasDisponívelCidadeQuantidade($dados->ibge);
		return [
			$diaristas, $quantidadeDiaristas, $dados->localidade
		];
	}
}