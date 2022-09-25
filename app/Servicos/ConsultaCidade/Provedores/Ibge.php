<?php

namespace App\Servicos\ConsultaCidade\Provedores;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Ibge
{
    public function codigoIBGE(int $codigo)
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
    }
}
