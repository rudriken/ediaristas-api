<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;
use App\Tarefas\Pagamento\EstornarPagamentoCliente;

class CancelarAutomaticamente
{
    public function __construct(private EstornarPagamentoCliente $estornarPagamentoCliente)
    {
    }

    public function executar()
    {
        $diarias = Diaria::comMenosDe24HorasParaAtendimentoSemDiarista();
        foreach ($diarias as $diaria) {
            $this->estornarPagamentoCliente->executar($diaria);
            $diaria->cancelar();
        }
    }
}
