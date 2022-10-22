<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\CandidatosDiaria;
use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
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
        $this->verificarDuplicidadeDeCandidato($diaria);
        $diaria->candidatos()->create(["diarista_id" => Auth::user()->id]);
        dd("depois da gravação");
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
}
