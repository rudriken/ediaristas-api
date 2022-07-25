<?php

namespace App\Servicos\ConsultaCEP;

class EnderecoResposta {
	public function __construct(
		public string $cep,
		public string $logradouro,
		public string $complemento,
		public string $bairro,
		public string $localidade,
		public string $uf,
		public string $ibge
	)
	{}
}