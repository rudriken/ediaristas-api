<?php

namespace App\Actions\Diarista;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class ObterDiaristasPorCEP {
	private InterfaceConsultaCEP $servicoCEP;

	public function __construct(InterfaceConsultaCEP $acao) {
		$this->servicoCEP = $acao;
	}

	/**
	 * Busca diaristas a partir de um CEP
	 *
	 * @param string $cep
	 * @return array
	 */
	public function executar(string $cep): array {
		$dados = $this->servicoCEP->buscar($cep);
		if ($dados === false) {
			throw ValidationException::withMessages(
				["cep" => "CEP inválido ou não encontrado"]
			);
		}
		$diaristas = User::diaristasDisponivelCidade($dados->ibge);
        $quantidadeDiaristas = User::diaristasDisponivelCidadeQuantidade($dados->ibge);
		return [
			$diaristas, $quantidadeDiaristas, $dados->localidade
		];
	}
}
