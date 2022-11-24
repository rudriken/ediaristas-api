<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;
use App\Tarefas\Pagamento\EstornarPagamentoCliente;

class CancelarAutomaticamente
{
    public function __construct(
        private EstornarPagamentoCliente $estornarPagamentoCliente
    ) {
    }

    /**
     * Cancela automaticamente as diárias pagas com menos de 24 horas para o atendimento e
     * que não possuem diarista para realizar o serviço
     *
     * @return void
     */
    public function executar(): void
    {
        $diarias = Diaria::comMenosDe24HorasParaAtendimentoSemDiarista();
        foreach ($diarias as $diaria) {
            $this->estornarPagamentoCliente->executar($diaria);
            $diaria->cancelar();
        }
    }
}
