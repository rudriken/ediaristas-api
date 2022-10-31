<?php

namespace App\Tarefas\Diarista;

use App\Models\Diaria;

class SelecionaDiaristaIndice
{
    public function executar(Diaria $diaria): int
    {
        foreach ($diaria->candidatos as $candidato) {
            var_dump($candidato->candidato);

            // a distância entre as residências do(a) candidato(a) e do(a) cliente

            // a reputação do(a) candidato(a)

            // fazer o cálculo do índice do(a) melhor candidato(a)

        }
        return 1;
    }
}
