<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;

class AvaliarDiaria
{
    public function executar(Diaria $diaria, array $dadosAvaliacao)
    {
        return $this->criaAvaliacao($diaria, $dadosAvaliacao);
    }

    private function criaAvaliacao(Diaria $diaria, array $dadosAvaliacao)
    {
        return $diaria->avaliacoes()->create($dadosAvaliacao + [
            "visibilidade" => 1, "avaliador_id" => Auth::user()->id, "avaliado_id" => 29,
        ]);
    }
}
