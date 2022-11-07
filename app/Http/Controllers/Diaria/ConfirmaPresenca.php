<?php

namespace App\Http\Controllers\Diaria;

use App\Models\Diaria;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diaria\ConfirmarPresenca;

class ConfirmaPresenca extends Controller
{

    public function __construct(private ConfirmarPresenca $confirmarPresenca)
    {
    }

    /**
     * Confirma a presença do(a) diarista no local de atendimento na data correta
     *
     * @param Diaria $diaria
     * @return JsonResponse
     */
    public function __invoke(Diaria $diaria): JsonResponse
    {
        $this->confirmarPresenca->executar($diaria);
        return resposta_padrao(200, "sucesso", "Presença do(a) diarista confirmada!");
    }
}
