<?php

namespace App\Http\Controllers\Diaria;

use App\Models\Diaria;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diaria\EscolheDiarista\CandidatarDiarista;

class CandidataDiarista extends Controller
{
    public function __construct(private CandidatarDiarista $candidatarDiarista)
    {
    }

    /**
     * Candidata um(a) diarista para realizar uma diária
     *
     * @param Diaria $diaria
     * @return JsonResponse
     */
    public function __invoke(Diaria $diaria): JsonResponse
    {
        $this->candidatarDiarista->executar($diaria);
        return resposta_padrao(200, "sucesso", "Ação executada com sucesso");
    }
}
