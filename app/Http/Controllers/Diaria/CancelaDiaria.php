<?php

namespace App\Http\Controllers\Diaria;

use App\Models\Diaria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Diaria\Cancelamento\CancelarDiaria;

class CancelaDiaria extends Controller
{

    public function __construct(private CancelarDiaria $cancelarDiaria)
    {
    }

    /**
     * Realiza o cancelamento de uma diária
     *
     * @param Diaria $diaria
     * @param Request $requisicao
     * @return JsonResponse
     */
    public function __invoke(Diaria $diaria, Request $requisicao): JsonResponse
    {
        $requisicao->validate(["motivo_cancelamento" => ["required", "string"]]);
        $this->cancelarDiaria->executar($diaria, $requisicao->motivo_cancelamento);
        return resposta_padrao(200, "sucesso", "A diária foi cancelada com sucesso");
    }
}
