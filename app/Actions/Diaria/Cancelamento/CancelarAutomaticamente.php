<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;

class CancelarAutomaticamente
{

    public function executar()
    {
        $diarias = Diaria::comMenosDe24HorasParaAtendimentoSemDiarista();
        foreach ($diarias as $diaria) {
            var_dump($diaria->id);
        }
    }
}

