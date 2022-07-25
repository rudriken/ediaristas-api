<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DiaristaPublicoCollection extends ResourceCollection {
	/**
	 * Suprime a chave "data" no retorno
	 *
	 * @var string
	 */
	public static $wrap = "diaristas";

	/**
	 * guarda a quantidade total de diaristas
	 *
	 * @var integer
	 */
	private int $quantidadeDiaristas;

	/**
	 * guarda a quantidade de diaristas restantes nas páginas seguintes da tela
	 *
	 * @var integer
	 */
	private int $quantidadeDiaristasNãoVisíveis;

	/**
	 * Guarda a cidade do CEP informado pelo usuário
	 *
	 * @var string
	 */
	private string $cidade;

	public function __construct($recurso, int $quantidadeDiaristas, string $cidade) {
		parent::__construct($recurso);
		$this->quantidadeDiaristas = $quantidadeDiaristas;
		$this->quantidadeDiaristasNãoVisíveis = $this->quantidadeDiaristas - 6;
		$this->cidade = $cidade;
	}
	
    /**
     * Transforme a coleção de recursos em um array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array {
        return [
			"diaristas" => DiaristaPublico::collection($this->collection),
			"quantidade_diaristas_restante" => 
				$this->quantidadeDiaristasNãoVisíveis > 0 ? 
				$this->quantidadeDiaristasNãoVisíveis : 0,
			"cidade_do_cep" => $this->cidade
		];
    }
}
