<?php

namespace App\Tarefas\Pagamento;

use App\Models\Diaria;
use App\Servicos\Pagamento\TransacaoResponse;
use App\Servicos\Pagamento\PagamentoInterface;
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
     * @param boolean $estornoCompleto
     * @return void
     */
    public function executar(Diaria $diaria, bool $estornoCompleto = true): void
    {
        $valor = $this->valor($diaria, $estornoCompleto);
        $pagamento = $diaria->pagamentoValido();
        $transacao = $this->realizaEstornoNoGateway($pagamento->transacao_id, $valor);
        $this->guardaTransacaoNoBancoDeDados($diaria, $pagamento->transacao_id, $valor);
        $this->validaStatusDoEstorno($transacao, $valor);
    }

    /**
     * Chama o serviço para realizar o estorno no Gateway de pagamento
     *
     * @param integer $transacaoId
     * @param float $valorEstorno
     * @return TransacaoResponse
     */
    private function realizaEstornoNoGateway(
        int $transacaoId,
        float $valorEstorno
    ): TransacaoResponse {
        try {
            $valorEstorno = intval($valorEstorno * 100);
            $transacao = $this->pagamento->estornar([
                "id" => $transacaoId,
                "amount" => $valorEstorno,
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
     * @param float $valorEstorno
     * @return void
     */
    private function guardaTransacaoNoBancoDeDados(
        Diaria $diaria,
        int $transacaoId,
        float $valorEstorno
    ): void {
        $diaria->pagamentos()->create([
            "status" => "estornado",
            "transacao_id" => $transacaoId,
            "valor" => $valorEstorno,
        ]);
    }

    /**
     * Valida se o status da transação está correto para o estorno
     *
     * @param TransacaoResponse $transacao
     * @return void
     */
    private function validaStatusDoEstorno(
        TransacaoResponse $transacao,
        float $valorEstorno
    ): void {
        $valorEstorno = intval($valorEstorno * 100);
        if ($transacao->valorEstornado !== $valorEstorno) {
            throw ValidationException::withMessages([
                "pagamento" => "Não foi possível estornar o pagamento"
            ]);
        }
    }

    /**
     * Retorna o valor do estorno
     *
     * @param Diaria $diaria
     * @param boolean $estornoCompleto
     * @return float
     */
    private function valor(Diaria $diaria, bool $estornoCompleto): float
    {
        return $estornoCompleto ? $diaria->preco : $diaria->preco / 2;
    }
}
