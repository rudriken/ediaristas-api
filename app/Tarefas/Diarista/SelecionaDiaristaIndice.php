<?php

namespace App\Tarefas\Diarista;

use App\Models\Diaria;
use App\Servicos\ConsultaDistancia\ConsultaDistanciaInterface;

class SelecionaDiaristaIndice
{

    public function __construct(private ConsultaDistanciaInterface $consultaDistancia)
    {
    }

    /**
     * Retorna o ID do(a) melhor candidato(a) para a diária
     *
     * @param Diaria $diaria
     * @return integer
     */
    public function executar(Diaria $diaria): int
    {
        $maiorIndice = 0;

        foreach ($diaria->candidatos as $candidato) {

            // a distância entre as residências do(a) candidato(a) e do serviço
            $distancia = $this->consultaDistancia->distanciaEntre2CEPs(
                $candidato->candidato->enderecoDiarista->cep,
                $diaria->cep
            );

            // a reputação do(a) candidato(a)
            $reputacao = $candidato->candidato->reputacao;

            // o cálculo do índice do(a) melhor candidato(a)
            $indiceCandidatoAtual = ($reputacao - ($distancia->distanciaEmKm / 10)) / 2;
            if ($indiceCandidatoAtual > $maiorIndice) {
                $diaristaEscolhidoId = $candidato->candidato->id;
                $maiorIndice = $indiceCandidatoAtual;
            }
        }
        return $diaristaEscolhidoId;
    }
}
