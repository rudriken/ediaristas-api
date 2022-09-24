<?php

namespace App\Http\Controllers\Endereco;

use App\Http\Requests\CepRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class BuscaCepApiExterna extends Controller {
	public function __construct(private InterfaceConsultaCEP $consultaCEP) {}

	/**
	 * Retorna os dados de endereço a partir do CEP
	 *
	 * @param CepRequest $request
	 * @return array
	 */
    public function __invoke(CepRequest $request): array {
		$dadosEndereco = $this->consultaCEP->buscar($request->cep);
		if ($dadosEndereco === false) {
			throw ValidationException::withMessages(
				["cep" => "CEP inválido ou não encontrado"]
			);
		}
		return (array) $dadosEndereco;
    }
}
