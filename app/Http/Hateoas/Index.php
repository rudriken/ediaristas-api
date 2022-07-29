<?php

namespace App\Http\Hateoas;

class Index {

	/**
	 * Links do HATEOAS
	 *
	 * @var array
	 */
	protected array $links = [];

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

	/**
	 * Adiciona um link no HATEOAS
	 *
	 * @param string $metodoHTTP
	 * @param string $descricao
	 * @param string $nomeRota
	 * @param array $parametrosRota
	 * @return void
	 */
	protected function adicionaLink(
		string $metodoHTTP, string $descricao, string $nomeRota, array $parametrosRota = []
	): void {
		$this->links[] = [
			"type" => $metodoHTTP,
			"rel" => $descricao,
			"uri" => route($nomeRota, $parametrosRota)
		];
	}
}