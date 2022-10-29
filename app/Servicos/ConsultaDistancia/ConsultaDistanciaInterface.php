<?php

namespace App\Servicos\ConsultaDistancia;

interface ConsultaDistanciaInterface {
    public function distanciaEntre2CEPs(string $origem, string $destino): DistanciaResponse;
}
