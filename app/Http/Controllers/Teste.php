<?php

namespace App\Http\Controllers;

use App\Servicos\ConsultaDistancia\ConsultaDistanciaInterface;

class Teste extends Controller
{

    public function __construct(private ConsultaDistanciaInterface $consultaDistancia)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $resposta = $this->consultaDistancia->distanciaEntre2CEPs("38402075", "38402028");
        dd($resposta);
    }
}
