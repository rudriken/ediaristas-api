<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterCidadesAtendidas;

class ObtemCidadesAtendidas extends Controller
{
    public function __construct(private ObterCidadesAtendidas $obterCidadesAtendidas)
    {
    }

    /**
     * Obtém a lista de cidades atendidas pelo(a) diarista
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        $cidadesAtendidas = $this->obterCidadesAtendidas->executar();
        return response($cidadesAtendidas, 200);
    }
}
