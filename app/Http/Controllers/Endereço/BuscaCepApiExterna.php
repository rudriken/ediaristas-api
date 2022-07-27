<?php

namespace App\Http\Controllers\Endereço;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class BuscaCepApiExterna extends Controller {
	public function __construct(private InterfaceConsultaCEP $consultaCEP) {}

	/**
	 * Retorna os dados de endereço a partir do CEP
	 *
	 * @param Request $request
	 * @return array
	 */
    public function __invoke(Request $request): array {
        $request->validate([
			"cep" => ["required", "numeric"]
		]);
		$dadosEndereço = $this->consultaCEP->buscar($request->cep);
		if ($dadosEndereço === false) { 
			throw ValidationException::withMessages(
				["cep" => "CEP inválido ou não encontrado"]
			);
		}
		return (array) $dadosEndereço;
    }
}
