<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CidadesAtendidasRequest;
use App\Actions\Diarista\DefinirCidadesAtendidas;

class DefineCidadesAtendidas extends Controller
{
    public function __construct(
        private DefinirCidadesAtendidas $definirCidadesAtendidas
    ) {
    }

    /**
     * Define as cidades atendidas pelo(a) diarista
     *
     * @param CidadesAtendidasRequest $request
     * @return JsonResponse
     */
    public function __invoke(CidadesAtendidasRequest $request): JsonResponse
    {
        $this->definirCidadesAtendidas->executar($request->cidades);
        return resposta_padrao(
            200,
            "sucesso",
            "Cidades definidas com sucesso para o(a) diarista"
        );
    }
}
