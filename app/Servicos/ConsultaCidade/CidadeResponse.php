<?php

namespace App\Servicos\ConsultaCidade;

class CidadeResponse
{

    /**
     * Define as propriedades e os dados da classe
     *
     * @param integer $codigoIBGE
     * @param string $cidade
     * @param string $estado
     */
    public function __construct(
        public int $codigoIBGE,
        public string $cidade,
        public string $estado
    ) {
    }
}
