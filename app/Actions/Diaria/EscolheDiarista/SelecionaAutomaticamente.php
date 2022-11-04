<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Tarefas\Diarista\SelecionaDiaristaIndice;
use Carbon\Carbon;

class SelecionaAutomaticamente
{

    public function __construct(private SelecionaDiaristaIndice $selecionaDiaristaIndice)
    {
    }

    public function executar()
    {
        $diarias = Diaria::where("status", 2)
            ->where("created_at", "<", Carbon::now()->subHours(24))
            ->withCount("candidatos")
            ->get();
        foreach ($diarias as $diaria) {
            if ($diaria->candidatos_count === 1) {
                $diaria->confirmarDiaria($diaria->candidatos[0]->diarista_id);
                continue;
            }
            if ($diaria->candidatos_count > 1) {
                $diaria->confirmarDiaria(
                    $this->selecionaDiaristaIndice->executar($diaria)
                );
            }
        }
    }
}
