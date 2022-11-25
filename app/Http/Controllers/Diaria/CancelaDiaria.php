<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\Cancelamento\CancelarDiaria;
use App\Http\Controllers\Controller;
use App\Models\Diaria;

class CancelaDiaria extends Controller
{

    public function __construct(private CancelarDiaria $cancelarDiaria)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Diaria $diaria)
    {
        $this->cancelarDiaria->executar($diaria);
    }
}
