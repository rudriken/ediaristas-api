<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\EscolheDiarista\CandidatarDiarista;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidataDiarista extends Controller
{
    public function __construct(private CandidatarDiarista $candidatarDiarista)
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
        $this->candidatarDiarista->executar();
    }
}
