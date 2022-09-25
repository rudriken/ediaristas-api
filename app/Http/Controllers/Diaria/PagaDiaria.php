<?php

namespace App\Http\Controllers\Diaria;

use App\Models\Diaria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Actions\Diaria\PagarDiaria;
use App\Http\Controllers\Controller;

class PagaDiaria extends Controller
{
    public function __construct(private PagarDiaria $pagarDiaria)
    {
    }

    /**
     * Paga uma diária
     *
     * @param Request $request
     * @param Diaria $diaria
     * @return JsonResponse
     */
    public function __invoke(Request $request, Diaria $diaria): JsonResponse
    {
        $request->validate(["card_hash" => "required"]);
        $this->pagarDiaria->executar($diaria, $request->card_hash);
        return resposta_padrao(200, "sucesso", "Diária paga com sucesso");
    }
}
