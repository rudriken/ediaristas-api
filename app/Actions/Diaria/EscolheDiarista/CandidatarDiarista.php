<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Illuminate\Support\Facades\Auth;

class CandidatarDiarista
{
    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    public function executar(Diaria $diaria)
    {
        $this->validaStatusDiaria->executar($diaria, 2);
        $diaria->candidatos()->create(["diarista_id" => Auth::user()->id]);
        dd("depois da gravação");
    }
}
