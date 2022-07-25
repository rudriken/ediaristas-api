<?php

namespace App\Servicos\ConsultaCEP;

interface InterfaceConsultaCEP {
	/**
	 * Define o padrão para o serviço para busca de endereço a partir do CEP
	 *
	 * @param string $cep
	 * @return false|EnderecoResposta
	 */
	public function buscar(string $cep): false | EnderecoResposta;
}
