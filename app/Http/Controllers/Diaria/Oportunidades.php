<?php

namespace App\Http\Controllers\Diaria;

use App\Http\Controllers\Controller;
use App\Actions\Diaria\PegarOportunidades;
use App\Http\Resources\OportunidadeCollection;

class Oportunidades extends Controller
{
    public function __construct(private PegarOportunidades $pegarOportunidades)
    {
    }

    /**
     * Retorna a lista de oportunidades para o usuário logado
     *
     * @return OportunidadeCollection
     */
    public function __invoke(): OportunidadeCollection
    {
        $oportunidades = $this->pegarOportunidades->executar();
        return new OportunidadeCollection($oportunidades);
    }
}
