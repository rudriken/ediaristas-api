<?php

namespace App\Servicos\ConsultaDistancia\Provedores;

use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use TeamPickr\DistanceMatrix\Frameworks\Laravel\DistanceMatrix;

class GoogleMatrix
{
    public function distanciaEntre2CEPs(string $origem, string $destino)
    {
        $licenca = new StandardLicense(config("google.key"));

        return DistanceMatrix::license($licenca)
            ->addOrigin($origem)
            ->addDestination($destino)
            ->request();
    }
}
