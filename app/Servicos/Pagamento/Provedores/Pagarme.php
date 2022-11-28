<?php

namespace App\Servicos\Pagamento\Provedores;

use PagarMe\Client;
use App\Servicos\Pagamento\TransacaoResponse;
use App\Servicos\Pagamento\PagamentoInterface;

class Pagarme implements PagamentoInterface
{
    public function __construct(private Client $pagarmeSDK)
    {
    }

    /**
     * Realiza a transação com o Gateway de pagamento 'Pagarme'
     *
     * @param array $dados
     * @return TransacaoResponse
     */
    public function pagar(array $dados): TransacaoResponse
    {
        $transacao = $this->pagarmeSDK->transactions()->create($dados);
        return new TransacaoResponse($transacao->id, $transacao->status);
    }

    /**
     * Realiza o estorno para o(a) cliente do valor pago
     *
     * @param array $dados
     * @return TransacaoResponse
     */
    public function estornar(array $dados): TransacaoResponse
    {
        $transacao = $this->pagarmeSDK->transactions()->refund($dados);
        return new TransacaoResponse(
            $transacao->id,
            $transacao->status,
            $transacao->refunded_amount
        );
    }
}
