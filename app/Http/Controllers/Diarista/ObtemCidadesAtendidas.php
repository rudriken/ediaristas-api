<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\ObterCidadesAtendidas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObtemCidadesAtendidas extends Controller
{
    public function __construct(private ObterCidadesAtendidas $obterCidadesAtendidas)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $cidadesAtendidas = $this->obterCidadesAtendidas->executar();
        return response($cidadesAtendidas, 200);
    }
}
