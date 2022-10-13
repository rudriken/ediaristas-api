<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\DefinirEndereco;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnderecoDiaristaRequest;
use \Illuminate\Http\Response;

class DefineEndereco extends Controller
{
    public function __construct(private DefinirEndereco $definirEndereco)
    {
    }

    /**
     * Define o endereço do usuario do tipo diarista
     *
     * @param EnderecoDiaristaRequest $request
     * @return Response
     */
    public function __invoke(EnderecoDiaristaRequest $request): Response
    {
        $endereco = $this->definirEndereco->executar($request->except("id"));
        return response($endereco, 200);
    }
}
