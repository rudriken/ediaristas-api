<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\DefinirEndereco;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnderecoDiaristaRequest;

class DefineEndereco extends Controller
{
    public function __construct(private DefinirEndereco $definirEndereco)
    {
    }
    /**
     * Handle the incoming request.
     *
     * @param  EnderecoDiaristaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(EnderecoDiaristaRequest $request)
    {
        $endereco = $this->definirEndereco->executar($request->except("id"));
        return response($endereco, 200);
    }
}
