<?php

namespace App\Servicos\ConsultaCidade;

class CidadeResponse
{
    public function __construct(
        public int $codigoIBGE,
        public string $cidade,
        public string $estado
    ) {
    }
}
