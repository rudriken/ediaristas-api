<?php

namespace App\Servicos\Pagamento;

interface PagamentoInterface
{
    public function pagar(array $dados): TransacaoResponse;
    public function estornar(array $dados): TransacaoResponse;
}
