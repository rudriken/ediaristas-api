<?php

namespace App\Actions\Diarista;

use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;

class DefinirEndereco
{
    public function executar(array $dados)
    {
        $diarista = Auth::user();
        return Endereco::updateOrCreate(
            ["user_id" => $diarista->id],
            $dados
        );
    }
}
