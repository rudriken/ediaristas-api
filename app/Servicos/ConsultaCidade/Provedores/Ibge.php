<?php

namespace App\Servicos\ConsultaCidade\Provedores;

use App\Servicos\ConsultaCidade\CidadeResponse;
use App\Servicos\ConsultaCidade\ConsultaCidadeInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Ibge implements ConsultaCidadeInterface
{
    public function codigoIBGE(int $codigo): CidadeResponse
    {
        $url = sprintf(
            "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/%s",
            $codigo
        );
        $resposta = Http::get($url)->throw();
        $dados = $resposta->json();
        if ($dados === []) {
            throw ValidationException::withMessages([
                "codigo_ibge" => "Código do IBGE inválido"
            ]);
        }

        return $this->populaCidadeResponse($dados);
    }

    /**
     * Define os dados do objeto de cidade
     *
     * @param array $dados
     * @return CidadeResponse
     */
    private function populaCidadeResponse(array $dados): CidadeResponse
    {
        return new CidadeResponse(
            $dados["id"],
            $dados["nome"],
            $dados["microrregiao"]["mesorregiao"]["UF"]["sigla"]
        );
    }
}
