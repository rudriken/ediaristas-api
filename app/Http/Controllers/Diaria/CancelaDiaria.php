<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\Cancelamento\CancelarDiaria;
use App\Http\Controllers\Controller;
use App\Models\Diaria;
use Illuminate\Http\Request;

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
    public function __invoke(Diaria $diaria, Request $requisicao)
    {
        $requisicao->validate(["motivo_cancelamento" => ["required", "string"]]);
        $this->cancelarDiaria->executar($diaria, $requisicao->motivo_cancelamento);
    }
}
