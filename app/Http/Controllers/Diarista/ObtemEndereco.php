<?php

namespace App\Http\Controllers\Diarista;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Actions\Diarista\ObterEndereco;

class ObtemEndereco extends Controller
{
    public function __construct(private ObterEndereco $obterEndereco)
    {
    }

    /**
     * Obtém o endereço do(a) diarista
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        $endereco = $this->obterEndereco->executar();
        return response($endereco, 200);
    }
}
