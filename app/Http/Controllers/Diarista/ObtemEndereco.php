<?php

namespace App\Http\Controllers\Diarista;

use App\Actions\Diarista\ObterEndereco;
use App\Http\Controllers\Controller;

class ObtemEndereco extends Controller
{
    public function __construct(private ObterEndereco $obterEndereco)
    {
    }

    public function __invoke()
    {
        $endereco = $this->obterEndereco->executar();
        return response($endereco, 200);
    }
}
