<?php

namespace App\Servicos\Pagamento\Provedores;

use App\Servicos\Pagamento\PagamentoInterface;
use App\Servicos\Pagamento\TransacaoResponse;
use PagarMe\Client;

class Pagarme implements PagamentoInterface
{
    public function __construct(private Client $pagarmeSDK)
    {
    }

    public function pagar(array $dados): TransacaoResponse
    {
        $transacao = $this->pagarmeSDK->transactions()->create($dados);
        return new TransacaoResponse($transacao->id, $transacao->status);
    }
}
