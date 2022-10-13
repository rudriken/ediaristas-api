<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\DefinirCidadesAtendidas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefineCidadesAtendidas extends Controller
{
    public function __construct(
        private DefinirCidadesAtendidas $definirCidadesAtendidas
    ) {
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->definirCidadesAtendidas->executar();
    }
}
