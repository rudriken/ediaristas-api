<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Tarefas\Usuario\AtualizaReputacao;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AvaliarDiaria
{
    public function __construct(
        private AtualizaReputacao $atualizaReputacao,
        private ValidaStatusDiaria $validaStatusDiaria
    ) {
    }

    public function executar(Diaria $diaria, array $dadosAvaliacao)
    {
        Gate::authorize("dono-diaria", $diaria);
        $this->validaStatusDiaria->executar($diaria, 4);
        $this->criaAvaliacao($diaria, $dadosAvaliacao);
        $this->atualizaReputacao->executar($this->obtemUsuarioAvaliadoId($diaria));
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
