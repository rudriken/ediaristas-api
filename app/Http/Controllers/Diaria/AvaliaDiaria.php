<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\AvaliarDiaria;
use App\Http\Controllers\Controller;
use App\Models\Diaria;
use Illuminate\Http\Request;

class AvaliaDiaria extends Controller
{
    public function __construct(private AvaliarDiaria $avaliarDiaria)
    {
    }

    public function __invoke(Diaria $diaria, Request $requisicao)
    {
        return $this->avaliarDiaria->executar($diaria, $requisicao->all());
    }
}
