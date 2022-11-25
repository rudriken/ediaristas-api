<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;

class CancelarDiaria
{
    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    public function executar(Diaria $diaria)
    {
        $this->validaStatusDiaria->executar($diaria, [2, 3]);
        dd("cheguei na Action 'CancelarDiaria'", $diaria->getAttributes());
    }
}
