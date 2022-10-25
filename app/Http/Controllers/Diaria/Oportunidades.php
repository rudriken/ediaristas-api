<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\PegarOportunidades;
use App\Http\Controllers\Controller;
use App\Http\Resources\OportunidadeCollection;
use Illuminate\Http\Request;

class Oportunidades extends Controller
{
    public function __construct(private PegarOportunidades $pegarOportunidades)
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
        $oportunidades = $this->pegarOportunidades->executar();
        return new OportunidadeCollection($oportunidades);
    }
}
