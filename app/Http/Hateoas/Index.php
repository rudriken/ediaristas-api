<?php

namespace App\Http\Hateoas;

class Index extends HateoasBase implements HateoasInterface {

	/**
	 * Retorna os links do HATEOAS para a rota inicial
	 *
	 * @return array
	 */
	public function links(): array {
		$this->adicionaLink("BET", "diaristas_cidade", "diaristas.busca_por_cep");
		$this->adicionaLink(
			"BET", "verificar_disponibilidade_atendimento", "endereços.disponibilidade"
		);
		$this->adicionaLink("BET", "endereco_cep", "endereços.cep");
		$this->adicionaLink("BET", "listar_servicos", "serviços.index");

		return $this->links;
	}
}
