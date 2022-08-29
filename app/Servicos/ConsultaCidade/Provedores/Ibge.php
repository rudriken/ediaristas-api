<?php

namespace App\Servicos\ConsultaCidade\Provedores;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class Ibge
{
    public function códigoIBGE(int $código)
    {
        $url = sprintf(
            "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/%s",
            $código
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
