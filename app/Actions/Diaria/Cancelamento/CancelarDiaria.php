<?php

namespace App\Actions\Diaria\Cancelamento;

use Carbon\Carbon;
use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Tarefas\Usuario\AtualizaReputacao;
use Illuminate\Validation\ValidationException;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use App\Tarefas\Pagamento\EstornarPagamentoCliente;

class CancelarDiaria
{
    public function __construct(
        private ValidaStatusDiaria $validaStatusDiaria,
        private AtualizaReputacao $atualizaReputacao,
        private EstornarPagamentoCliente $estornarPagamentoCliente
    ) {
    }

    /**
     * Realiza o cancelamento de uma diária
     *
     * @param Diaria $diaria
     * @param string $motivoCancelamento
     * @return void
     */
    public function executar(Diaria $diaria, string $motivoCancelamento): void
    {
        $this->validaStatusDiaria->executar($diaria, [2, 3]);
        $this->verificaDataAtendimento($diaria->data_atendimento);
        Gate::authorize("dono-diaria", $diaria);
        $diaria->cancelar($motivoCancelamento);
        $this->penalizacao($diaria);
    }

    /**
     * Verifica se já não passou da data de atendimento no momento do cancelamento da diária
     *
     * @param string $dataAtendimento
     * @return void
     */
    private function verificaDataAtendimento(string $dataAtendimento): void
    {
        $dataAtendimento = new Carbon($dataAtendimento);
        $agora = Carbon::now();

        if ($agora > $dataAtendimento) {
            throw ValidationException::withMessages([
                "data_atendimento" => "Não é mais possível cancelar essa diária. " .
                    "Entre em contato com o nosso suporte!",
            ]);
        }
    }

    /**
     * Define a penalização para o usuário dos tipos 'cliente' ou 'diarista'
     *
     * @param Diaria $diaria
     * @return void
     */
    private function penalizacao(Diaria $diaria): void
    {
        // verificar se tem penalização
        $naoTemPenalidade = $this->verificaSeNaoTemPenalizacao($diaria->data_atendimento);
        $tipoUsuario = Auth::user()->tipo_usuario;

        if ($tipoUsuario == "2") {
            $this->penalizacaoDiarista($diaria, $naoTemPenalidade);
            return;
        }

        // fazer o reenbolso
        $this->estornarPagamentoCliente->executar($diaria, $naoTemPenalidade);
    }

    /**
     * Verifica pela data de atendimento se tem ou não penalização.
     *
     * @param string $dataAtendimento
     * @return boolean
     */
    private function verificaSeNaoTemPenalizacao(string $dataAtendimento): bool
    {
        $dataAtendimento = new Carbon($dataAtendimento);
        $diferencaEmHoras = Carbon::now()->diffInHours($dataAtendimento, false);
        return $diferencaEmHoras > 24;
    }

    /**
     * Verifica se tem penalização para o(a) diarista, e se tiver, penaliza.
     *
     * @param Diaria $diaria
     * @param boolean $naoTemPenalidade
     * @return void
     */
    private function penalizacaoDiarista(Diaria $diaria, bool $naoTemPenalidade): void
    {
        if ($naoTemPenalidade) {
            return;
        }
        $usuarioLogadoId = Auth::user()->id;
        $diaria->avaliacoes()->create([
            "visibilidade"  => 0,
            "nota"          => 1,
            "descricao"     => "penalização diária cancelada",
            "diaria_id"     => $diaria->id,
            "avaliado_id"   => $usuarioLogadoId,
        ]);
        $this->atualizaReputacao->executar($usuarioLogadoId);
    }
}
