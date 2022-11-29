<?php

namespace App\Http\Hateoas;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Diaria extends HateoasBase implements HateoasInterface
{
    /**
     * Retorna os links do HATEOAS para a diária
     *
     * @param Model|null $diaria
     * @return array
     */
    public function links(?Model $diaria): array
    {
        $this->adicionaLink("GET", "self", "diarias.show", ["diaria" => $diaria->id]);
        $this->linkPagar($diaria);
        $this->linkConfirmar($diaria);
        $this->linkAvaliar($diaria);
        $this->linkCancelar($diaria);
        return $this->links;
    }

    /**
     * Adiciona o link de pagamento na diária
     *
     * @param Model $diaria
     * @return void
     */
    private function linkPagar(Model $diaria): void
    {
        if ($diaria->status == 1) {
            $this->adicionaLink(
                "POST",
                "pagar_diaria",
                "diarias.pagar",
                ["diaria" => $diaria->id]
            );
        }
    }

    /**
     * Adiciona o link para confirmar a presença do(a) diarista
     *
     * @param Model $diaria
     * @return void
     */
    private function linkConfirmar(Model $diaria): void
    {
        $usuarioLogado = Auth::user();

        /* abaixo temos as quatro regras de negócio */
        $usuarioTipoCliente = $usuarioLogado->tipo_usuario == 1;
        $usuarioDonoDaDiaria = $diaria->cliente_id == $usuarioLogado->id;
        $diariaConfirmada = $diaria->status == 3;
        $depoisDataAtendimento = Carbon::now() > Carbon::parse($diaria->data_atendimento);

        if (
            $usuarioTipoCliente &&
            $usuarioDonoDaDiaria &&
            $diariaConfirmada &&
            $depoisDataAtendimento
        ) {
            $this->adicionaLink(
                "PATCH",
                "confirmar_diarista",
                "diarias.confirmar",
                ["diaria" => $diaria->id]
            );
        }
    }

    /**
     * Define o link para avaliar a diária
     *
     * @param Model $diaria
     * @return void
     */
    private function linkAvaliar(Model $diaria): void
    {
        $usuarioNaoAvaliou = !$diaria->verificaDuplicidadeDeAvaliacao(Auth::user()->id);
        $diariaConcluida = $diaria->status == 4;
        if ($diariaConcluida && $usuarioNaoAvaliou) {
            $this->adicionaLink(
                "PATCH",
                "avaliar_diaria",
                "diarias.avaliar",
                ["diaria" => $diaria->id]
            );
        }
    }

    /**
     * Adiciona o link para cancelar a diária
     *
     * @param Model $diaria
     * @return void
     */
    private function linkCancelar(Model $diaria): void
    {
        $antesDataAtendimento = Carbon::now() < Carbon::parse($diaria->data_atendimento);
        $diariaPagaOuConfirmada = $diaria->status == 2 || $diaria->status == 3;

        if ($antesDataAtendimento && $diariaPagaOuConfirmada) {
            $this->adicionaLink(
                "PATCH",
                "cancelar_diaria",
                "diarias.cancelar",
                ["diaria" => $diaria->id]
            );
        }
    }
}
