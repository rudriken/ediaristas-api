<?php

namespace App\Tarefas\Diarista;

use App\Models\Diaria;
use App\Servicos\ConsultaDistancia\ConsultaDistanciaInterface;

class SelecionaDiaristaIndice
{

    public function __construct(private ConsultaDistanciaInterface $consultaDistancia)
    {
    }

    public function executar(Diaria $diaria): int
    {
        foreach ($diaria->candidatos as $candidato) {
            // a distância entre as residências do(a) candidato(a) e do(a) cliente
            $distancia = $this->consultaDistancia->distanciaEntre2CEPs(
                $candidato->candidato->enderecoDiarista->cep,
                $diaria->cep
            );
            var_dump($distancia);

            // a reputação do(a) candidato(a)

            // fazer o cálculo do índice do(a) melhor candidato(a)

        }
        dd("depois do loop");
        return 1;
    }
}
