<?php

namespace App\Servicos\ConsultaDistancia;

class DistanciaResponse
{
    public function __construct(public float $distanciaEmKm)
    {
    }
}
