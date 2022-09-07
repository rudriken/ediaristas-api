<?php

namespace App\Http\Controllers\Diaria;

use Illuminate\Http\Request;
use App\Actions\Diaria\PagarDiaria;
use App\Http\Controllers\Controller;

class PagaDiaria extends Controller
{
    public function __construct(private PagarDiaria $pagarDiaria)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->pagarDiaria->executar();
    }
}
