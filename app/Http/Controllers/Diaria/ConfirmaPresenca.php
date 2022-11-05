<?php

namespace App\Http\Controllers\Diaria;

use App\Actions\Diaria\ConfirmarPresenca;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmaPresenca extends Controller
{

    public function __construct(private ConfirmarPresenca $confirmarPresenca)
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
        $this->confirmarPresenca->executar();
    }
}
