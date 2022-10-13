<?php

namespace App\Actions\Diarista;

use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;

class DefinirEndereco
{
    public function executar(array $dados)
    {
        $usuario = Auth::user();
        return Endereco::updateOrCreate(
            ["user_id" => $usuario->id],
            $dados
        );
    }
}
