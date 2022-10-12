<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\DefinirEndereco;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefineEndereco extends Controller
{
    public function __construct(private DefinirEndereco $definirEndereco)
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
        $this->definirEndereco->executar();
    }
}
