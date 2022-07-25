<?php

namespace App\Servicos\ConsultaCEP\ProvedoresCEP;

use Illuminate\Support\Facades\Http;
use App\Servicos\ConsultaCEP\EnderecoResposta;
use App\Servicos\ConsultaCEP\InterfaceConsultaCEP;

class ViaCEP implements InterfaceConsultaCEP {
	/**
	 * Buscar endereço utilizando a API do ViaCEP
	 *
	 * @param string $cep
	 * @return false|EnderecoResposta
	 */
	public function buscar(string $cep): false | EnderecoResposta {
		$resposta = Http::get("http://viacep.com.br/ws/$cep/json/");
		if ($resposta->failed()) {
			return false;
		}
		$dados = $resposta->json();
		if (isset($dados["erro"]) && $dados["erro"] === "true") {
			return false;
		}
		return $this->populaEndereçoResposta($dados);
	}

	/**
	 * Formata a saída para endereço resposta
	 * 
	 * @param array $dados
	 * @return EnderecoResposta
	 */
	private function populaEndereçoResposta(array $dados): EnderecoResposta {
		return new EnderecoResposta(
			logradouro: $dados["logradouro"],
			complemento: $dados["complemento"],
			uf: $dados["uf"],
			ibge: $dados["ibge"],
			localidade: $dados["localidade"],
			cep: $dados["cep"],
			bairro: $dados["bairro"],
		);
	}
}
