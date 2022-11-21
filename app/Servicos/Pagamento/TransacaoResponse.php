<?php

namespace App\Servicos\Pagamento;

class TransacaoResponse
{
    public function __construct(public int $transacaoId, public string $transacaoStatus)
    {
    }
}
