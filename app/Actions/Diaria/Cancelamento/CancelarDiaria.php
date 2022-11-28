<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;
use App\Tarefas\Pagamento\EstornarPagamentoCliente;
use App\Tarefas\Usuario\AtualizaReputacao;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CancelarDiaria
{
    public function __construct(
        private ValidaStatusDiaria $validaStatusDiaria,
        private AtualizaReputacao $atualizaReputacao,
        private EstornarPagamentoCliente $estornarPagamentoCliente
    ) {
    }

    public function executar(Diaria $diaria, string $motivoCancelamento)
    {
        $this->validaStatusDiaria->executar($diaria, [2, 3]);
        $this->verificaDataAtendimento($diaria->data_atendimento);
        Gate::authorize("dono-diaria", $diaria);
        $diaria->cancelar($motivoCancelamento);
        $this->penalizacao($diaria);
        dd("diária cancelada com sucesso!");
    }

    private function verificaDataAtendimento(string $dataAtendimento)
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

    private function penalizacao(Diaria $diaria)
    {
        // verificar se tem penalização
        $naoTemPenalidade = $this->verificaSeNaoTemPenalizacao($diaria->data_atendimento);
        $tipoUsuario = Auth::user()->tipo_usuario;

        if ($tipoUsuario == "2") {
            return $this->penalizacaoDiarista($diaria, $naoTemPenalidade);
        }

        // fazer o reenbolso
        $this->estornarPagamentoCliente->executar($diaria, $naoTemPenalidade);
    }

    private function verificaSeNaoTemPenalizacao(string $dataAtendimento): bool
    {
        $dataAtendimento = new Carbon($dataAtendimento);
        $diferencaEmHoras = Carbon::now()->diffInHours($dataAtendimento, false);
        return $diferencaEmHoras > 24;
    }

    private function penalizacaoDiarista(Diaria $diaria, bool $naoTemPenalidade)
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
