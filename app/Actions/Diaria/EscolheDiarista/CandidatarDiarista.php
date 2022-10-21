<?php

namespace App\Actions\Diaria\EscolheDiarista;

use App\Models\Diaria;
use Illuminate\Support\Facades\Auth;

class CandidatarDiarista
{
    public function executar(Diaria $diaria)
    {
        $diaria->candidatos()->create(["diarista_id" => Auth::user()->id]);
        dd("depois da gravação");
    }
}
