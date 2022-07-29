<?php

namespace App\Http\Hateoas;

class HateoasBase {
	
	/**
	 * Links do HATEOAS
	 *
	 * @var array
	 */
	protected array $links = [];

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