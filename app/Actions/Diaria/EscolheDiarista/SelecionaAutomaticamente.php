<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Tarefas\Diarista\SelecionaDiaristaIndice;

class SelecionaAutomaticamente
{

    public function __construct(private SelecionaDiaristaIndice $selecionaDiaristaIndice)
    {
    }

    /**
     * Busca as diárias pagas com mais de 24 horas de criadas e
     * escolhe o(a) diarista mais apropriado(a) para ela
     *
     * @return void
     */
    public function executar(): void
    {
        $diarias = Diaria::pagasComMaisDe24Horas();
        foreach ($diarias as $diaria) {
            if ($diaria->candidatos_count === 1) {
                $diaria->confirmarDiaria($diaria->candidatos[0]->diarista_id);
            }
            if ($diaria->candidatos_count > 1) {
                $diaria->confirmarDiaria(
                    $this->selecionaDiaristaIndice->executar($diaria)
                );
            }
        }
    }
}
