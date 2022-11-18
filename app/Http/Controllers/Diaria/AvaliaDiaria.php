<?php

namespace App\Http\Controllers\Diaria;

use App\Models\Diaria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diaria\AvaliarDiaria;

class AvaliaDiaria extends Controller
{
    public function __construct(private AvaliarDiaria $avaliarDiaria)
    {
    }

    /**
     * Define a avaliação do(a) usuário logado para a diária
     *
     * @param Diaria $diaria
     * @param Request $requisicao
     * @return JsonResponse
     */
    public function __invoke(Diaria $diaria, Request $requisicao): JsonResponse
    {
        $requisicao->validate([
            "nota" => ["required", "integer", "min:0", "max:5"],
            "descricao" => ["required", "string"],
        ]);
        $this->avaliarDiaria->executar($diaria, $requisicao->all());
        return resposta_padrao(200, "sucesso", "diaria avaliada com sucesso");
    }
}
