<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CandidatarDiarista
{
    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    public function executar(Diaria $diaria)
    {
        Gate::authorize("tipo-diarista");
        $this->validaStatusDiaria->executar($diaria, 2);
        if ($this->criadaAMenosDe24Horas($diaria)) {
            /* quando a diária foi criada a menos de 24 horas */
            $this->verificarDuplicidadeDeCandidato($diaria);
            return $diaria->candidatos()->create(["diarista_id" => Auth::user()->id]);
        }
        /* quando a diária foi criada a mais de 24 horas */
        $diaria->diarista_id = Auth::user()->id;
        $diaria->status = 3;
        $diaria->save();
    }

    private function verificarDuplicidadeDeCandidato(Diaria $diaria)
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

    private function criadaAMenosDe24Horas(Diaria $diaria)
    {
        $dataCriacaoDiaria = new Carbon($diaria->created_at);
        $horasDesdeACriacao = $dataCriacaoDiaria->diffInHours(Carbon::now(), false);
        return $horasDesdeACriacao < 24;
    }
}
