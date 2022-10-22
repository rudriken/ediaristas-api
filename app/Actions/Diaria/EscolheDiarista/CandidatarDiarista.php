<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CandidatarDiarista
{
    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    /**
     * Define um(a) candidato(a) para diárias com criação menor que 24 horas
     * E define diretamente o(a) diarista para a diária caso criação maior que 24 horas
     *
     * @param Diaria $diaria
     * @return boolean|Model
     */
    public function executar(Diaria $diaria): bool|Model
    {
        Gate::authorize("tipo-diarista");
        $this->validaStatusDiaria->executar($diaria, 2);
        $diaristaId = Auth::user()->id;
        if ($this->criadaAMenosDe24Horas($diaria)) {
            /* quando a diária foi criada a menos de 24 horas */
            $this->verificarDuplicidadeDeCandidato($diaria);
            return $diaria->defineCandidato($diaristaId);
        }
        /* quando a diária foi criada a mais de 24 horas */
        return $diaria->confirmarDiaria($diaristaId);
    }

    /**
     * Verifica se o usuário já está candidatado para a diária
     *
     * @param Diaria $diaria
     * @return void
     */
    private function verificarDuplicidadeDeCandidato(Diaria $diaria): void
    {
        $diaristaCandidato = $diaria
            ->candidatos()
            ->where("diarista_id", Auth::user()->id)
            ->first();
        if ($diaristaCandidato) {
            throw ValidationException::withMessages([
                "dado_criacao" => "O(A) diarista já é candidato(a) dessa diária"
            ]);
        }
    }

    /**
     * Verifica se a diária foi criada a menos de 24 horas
     *
     * @param Diaria $diaria
     * @return bool
     */
    private function criadaAMenosDe24Horas(Diaria $diaria): bool
    {
        $dataCriacaoDiaria = new Carbon($diaria->created_at);
        $horasDesdeACriacao = $dataCriacaoDiaria->diffInHours(Carbon::now(), false);
        return $horasDesdeACriacao < 24;
    }
}
