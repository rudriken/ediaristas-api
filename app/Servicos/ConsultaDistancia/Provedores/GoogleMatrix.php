<?php

namespace App\Servicos\ConsultaDistancia\Provedores;

use App\Servicos\ConsultaDistancia\DistanciaResponse;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;
use TeamPickr\DistanceMatrix\Frameworks\Laravel\DistanceMatrix;

class GoogleMatrix
{
    public function distanciaEntre2CEPs(string $origem, string $destino)
    {
        $licenca = new StandardLicense(config("google.key"));

        $resposta = DistanceMatrix::license($licenca)
            ->addOrigin($this->formataCEP($origem))
            ->addDestination($this->formataCEP($destino))
            ->request();

        return new DistanciaResponse(
            $resposta->json["rows"][0]["elements"][0]["distance"]["value"] / 1000
        );
    }

    /**
     * Valida e formata o CEP
     *
     * @param string $cep
     * @return string
     */
    private function formataCEP(string $cep): string
    {
        $this->verificaPadraoCEP($cep);
        return substr_replace($cep, "-", 5, 0);
    }

    /**
     * Verifica o tamanho e padrão do CEP
     *
     * @param string $cep
     * @return void
     */
    private function verificaPadraoCEP(string $cep): void
    {
        if (strlen($cep) !== 8) {
            throw new \Exception("O CEP deve ter 8 dígitos", 1);
        }

        if (!preg_match("/^[0-9]+$/", $cep)) {
            throw new \Exception("O CEP deve ter apenas números", 1);
        }
    }
}
