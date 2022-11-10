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
            "visibilidade" => 1,
            "avaliador_id" => Auth::user()->id,
            "avaliado_id" => $this->obtemUsuarioAvaliadoId($diaria),
        ]);
    }

    /**
     * Retorna o ID do usuário que está sendo avaliado
     *
     * @param Diaria $diaria
     * @return integer
     */
    private function obtemUsuarioAvaliadoId(Diaria $diaria): int
    {
        $tipoUsuarioLogado = Auth::user()->tipo_usuario;
        if ($tipoUsuarioLogado == 1) {
            return $diaria->diarista_id;
        }
        return $diaria->cliente_id;
    }
}
