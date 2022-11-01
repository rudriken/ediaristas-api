<?php

namespace App\Http\Controllers;

use App\Models\Diaria;
use App\Tarefas\Diarista\SelecionaDiaristaIndice;

class Teste extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SelecionaDiaristaIndice $selecionaDiarista)
    {
        $diaria = Diaria::find(61);
        $diaristaEscolhidoId = $selecionaDiarista->executar($diaria);
        dd($diaristaEscolhidoId);
    }
}
