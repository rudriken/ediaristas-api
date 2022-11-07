<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Illuminate\Support\Facades\Gate;

class ConfirmarPresenca
{

    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    public function executar(Diaria $diaria)
    {
        Gate::authorize("tipo-cliente");
        Gate::authorize("dono-diaria", $diaria);
        $this->validaStatusDiaria->executar($diaria, 3);
        $diaria->status = 4;
        $diaria->save();
    }
}
