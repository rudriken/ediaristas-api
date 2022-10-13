<?php

namespace App\Actions\Diarista;

use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DefinirEndereco
{

    /**
     * Define o endereço do usuario do tipo diarista
     *
     * @param array $dados
     * @return Endereco
     */
    public function executar(array $dados): Endereco
    {
        Gate::authorize("tipo-diarista");
        $usuario = Auth::user();
        return Endereco::updateOrCreate(
            ["user_id" => $usuario->id],
            $dados
        );
    }
}
