<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;

class CancelarDiaria
{
    public function executar(Diaria $diaria)
    {
        dd("cheguei na Action 'CancelarDiaria'", $diaria->getAttributes());
    }
}
