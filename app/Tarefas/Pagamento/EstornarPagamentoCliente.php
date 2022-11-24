<?php

namespace App\Tarefas\Pagamento;

use App\Models\Diaria;
use App\Servicos\Pagamento\PagamentoInterface;
use Illuminate\Validation\ValidationException;

class EstornarPagamentoCliente
{
    public function __construct(private PagamentoInterface $pagamento)
    {
    }

    public function executar(Diaria $diaria)
    {
        $pagamento = $diaria->pagamentos()->where("status", "pago")->first();
        $transacao = $this->pagamento->estornar([
            "id" => $pagamento->transacao_id,
        ]);
        $diaria->pagamentos()->create([
            "status" => "estornado",
            "transacao_id" => $pagamento->transacao_id,
            "valor" => $diaria->preco
        ]);
        if ($transacao->transacaoStatus !== "refunded") {
            throw ValidationException::withMessages([
                "pagamento" => "Não foi possível estornar o pagamento"
            ]);
        }
    }
}
