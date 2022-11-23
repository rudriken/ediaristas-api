<?php

namespace App\Tarefas\Pagamento;

use App\Models\Diaria;

class EstornarPagamentoCliente
{
    public function executar(Diaria $diaria)
    {
        dd($diaria->id);
    }
}
