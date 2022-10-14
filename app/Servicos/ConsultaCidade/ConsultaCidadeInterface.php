<?php

namespace App\Servicos\ConsultaCidade;

interface ConsultaCidadeInterface
{
    public function codigoIBGE(int $codigo): CidadeResponse;
}
