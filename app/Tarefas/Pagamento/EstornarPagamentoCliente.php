<?php

namespace App\Tarefas\Pagamento;

use App\Models\Diaria;
use App\Servicos\Pagamento\PagamentoInterface;
use App\Servicos\Pagamento\TransacaoResponse;
use Illuminate\Validation\ValidationException;

class EstornarPagamentoCliente
{
    public function __construct(private PagamentoInterface $pagamento)
    {
    }

    /**
     * Realiza o estorno no Gateway de pagamento
     *
     * @param Diaria $diaria
     * @return void
     */
    public function executar(Diaria $diaria): void
    {
        $pagamento = $diaria->pagamentoValido();
        $transacao = $this->realizaEstornoNoGateway($pagamento->transacao_id);
        $this->guardaTransacaoNoBancoDeDados($diaria, $pagamento->transacao_id);
        $this->validaStatusDoEstorno($transacao);
    }

    /**
     * Chama o serviço para realizar o estorno no Gateway de pagamento
     *
     * @param integer $transacaoId
     * @return TransacaoResponse
     */
    private function realizaEstornoNoGateway(int $transacaoId): TransacaoResponse
    {
        try {
            $transacao = $this->pagamento->estornar([
                "id" => $transacaoId,
            ]);
        } catch (\Throwable $erro) {
            throw ValidationException::withMessages([
                "pagamento" => $erro->getMessage()
            ]);
        }

        return $transacao;
    }

    /**
     * Guarda a transação no banco de dados local
     *
     * @param Diaria $diaria
     * @param integer $transacaoId
     * @return void
     */
    private function guardaTransacaoNoBancoDeDados(Diaria $diaria, int $transacaoId): void
    {
        $diaria->pagamentos()->create([
            "status" => "estornado",
            "transacao_id" => $transacaoId,
            "valor" => $diaria->preco
        ]);
    }

    /**
     * Valida se o status da transação está correto para o estorno
     *
     * @param TransacaoResponse $transacao
     * @return void
     */
    private function validaStatusDoEstorno(TransacaoResponse $transacao): void
    {
        if ($transacao->transacaoStatus !== "refunded") {
            throw ValidationException::withMessages([
                "pagamento" => "Não foi possível estornar o pagamento"
            ]);
        }
    }
}
