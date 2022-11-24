<?php

namespace App\Tarefas\Pagamento;

use App\Models\Diaria;
use App\Servicos\Pagamento\PagamentoInterface;

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
        dd($transacao);
    }
}
