<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Servicos\Pagamento\PagamentoInterface;
use App\Servicos\Pagamento\TransacaoResponse;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class PagarDiaria
{

    public function __construct(
        private ValidaStatusDiaria $validaStatusDiaria,
        private PagamentoInterface $pagamento
    ) {
    }

    /**
     * Executa o pagamento da diária
     *
     * @param Diaria $diaria
     * @param string $cardHash
     * @return boolean
     */
    public function executar(Diaria $diaria, string $cardHash): bool
    {
        $this->realizaValidacoes($diaria);

        // integração com o gateway de pagamento
        $transacao = $this->realizaTransacaoComGateway($diaria, $cardHash);
        $this->guardaTransacaoNoBanco($diaria, $transacao);
        $this->validaStatusPagamento($transacao);

        return $diaria->pagar();
    }

    /**
     * Realiza as validações antes do pagamento
     *
     * @param Diaria $diaria
     * @return void
     */
    private function realizaValidacoes(Diaria $diaria): void
    {
        $this->validaStatusDiaria->executar($diaria, 1);
        Gate::authorize("tipo-cliente");
        Gate::authorize("dono-diaria", $diaria);
    }

    /**
     * Chama o serviço de pagamento para realizar a transação
     *
     * @param Diaria $diaria
     * @param string $cardHash
     * @return TransacaoResponse
     */
    private function realizaTransacaoComGateway(
        Diaria $diaria,
        string $cardHash
    ): TransacaoResponse {
        try {
            $transacao = $this->pagamento->pagar([
                "amount" => intval($diaria->preco * 100),
                "card_hash" => $cardHash,
                "async" => false,
            ]);
        } catch (\Throwable $excecao) {
            throw ValidationException::withMessages([
                "pagamento" => $excecao->getMessage(),
            ]);
        }
        return $transacao;
    }

    /**
     * Salva o resultado da transação do Gateway no banco de dados
     *
     * @param Diaria $diaria
     * @param TransacaoResponse $transacao
     * @return void
     */
    private function guardaTransacaoNoBanco(
        Diaria $diaria,
        TransacaoResponse $transacao
    ): void {
        $diaria->pagamentos()->create([
            "status"        => $transacao->transacaoStatus === "paid" ? "pago" : "reprovado",
            "transacao_id"  => $transacao->transacaoId,
            "valor"         => $diaria->preco
        ]);
    }

    /**
     * Valida se o status da transação é 'pago', se não for é gerada uma exceção
     *
     * @param TransacaoResponse $transacao
     * @return void
     */
    public function validaStatusPagamento(TransacaoResponse $transacao): void
    {
        if ($transacao->transacaoStatus !== "paid") {
            throw ValidationException::withMessages([
                "pagamento" => "Pagamento Reprovado"
            ]);
        }
    }
}
