<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use App\Tarefas\Usuario\AtualizaReputacao;
use Illuminate\Validation\ValidationException;
use App\Verificadores\Diaria\ValidaStatusDiaria;

class AvaliarDiaria
{
    public function __construct(
        private AtualizaReputacao $atualizaReputacao,
        private ValidaStatusDiaria $validaStatusDiaria
    ) {
    }

    /**
     * Define a avaliação do(a) usuário logado para a diária
     *
     * @param Diaria $diaria
     * @param array $dadosAvaliacao
     * @return void
     */
    public function executar(Diaria $diaria, array $dadosAvaliacao): void
    {
        Gate::authorize("dono-diaria", $diaria);
        $this->validaStatusDiaria->executar($diaria, 4);
        $this->verificaDuplicidadeDeAvaliacao($diaria);
        $this->criaAvaliacao($diaria, $dadosAvaliacao);
        $this->atualizaReputacao->executar($this->obtemUsuarioAvaliadoId($diaria));
        $this->defineStatusAvaliado($diaria);
    }

    /**
     * Verifica se o usuário logado já avaliou a diária
     *
     * @param Diaria $diaria
     * @return void
     */
    private function verificaDuplicidadeDeAvaliacao(Diaria $diaria): void
    {
        $usuarioLogado = Auth::user();
        $usuarioJaAvaliou = $diaria->verificaDuplicidadeDeAvaliacao($usuarioLogado->id);
        if ($usuarioJaAvaliou) {
            throw ValidationException::withMessages([
                "avaliador_id" => "O usuário já avaliou essa diária",
            ]);
        }
    }

    /**
     * Cria uma avaliação para a diária
     *
     * @param Diaria $diaria
     * @param array $dadosAvaliacao
     * @return Model
     */
    private function criaAvaliacao(Diaria $diaria, array $dadosAvaliacao): Model
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

    /**
     * Muda o status da diária para "avaliado" quando as duas partes fizerem a avaliação
     *
     * @param Diaria $diaria
     * @return boolean
     */
    private function defineStatusAvaliado(Diaria $diaria): bool
    {
        $quantidadeAvaliacoes = $diaria->avaliacoes()->count();
        if ($quantidadeAvaliacoes === 2) {
            return $diaria->update(["status" => 6]);
        }
        return false;
    }
}
