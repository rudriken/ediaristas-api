<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\AvaliarDiaria;
use App\Http\Controllers\Controller;

class AvaliaDiaria extends Controller
{
    public function __construct(private AvaliarDiaria $avaliarDiaria)
    {
    }

    public function __invoke()
    {
        $this->avaliarDiaria->executar();
    }
}
