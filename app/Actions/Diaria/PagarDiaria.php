<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;

class PagarDiaria {
    public function executar(Diaria $diaria)
    {
        $diaria->pagar();
    }
}
