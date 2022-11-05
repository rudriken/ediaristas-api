<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Tarefas\Diarista\SelecionaDiaristaIndice;

class SelecionaAutomaticamente
{

    public function __construct(private SelecionaDiaristaIndice $selecionaDiaristaIndice)
    {
    }

    public function executar()
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
