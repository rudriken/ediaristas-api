<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\ConfirmarPresenca;
use App\Http\Controllers\Controller;
use App\Models\Diaria;

class ConfirmaPresenca extends Controller
{

    public function __construct(private ConfirmarPresenca $confirmarPresenca)
    {
    }

    public function __invoke(Diaria $diaria)
    {
        $this->confirmarPresenca->executar($diaria);
    }
}
