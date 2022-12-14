<?php

namespace App\Actions\Diarista;

use App\Models\User;
use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ObterEndereco
{

    /**
     * Obtém o endereço do(a) diarista
     *
     * @return Endereco
     */
    public function executar(): Endereco
    {
        Gate::authorize("tipo-diarista");
        $login = Auth::user();

        $diarista = new User;

        $diarista->id = $login->id;
        $diarista->nome_completo = $login->nome_completo;
        $diarista->cpf = $login->cpf;
        $diarista->nascimento = $login->nascimento;
        $diarista->foto_documento = $login->foto_documento;
        $diarista->foto_usuario = $login->foto_usuario;
        $diarista->telefone = $login->telefone;
        $diarista->tipo_usuario = $login->tipo_usuario;
        $diarista->chave_pix = $login->chave_pix;
        $diarista->reputacao = $login->reputacao;
        $diarista->email = $login->email;
        // $diarista->email_verified_at = $login->email_verified_at;
        $diarista->password = $login->password;
        // $diarista->remember_token = $login->remember_token;
        $diarista->created_at = $login->created_at;
        // $diarista->updated_at = $login->updated_at;
        $diarista->setConnection("mysql");
        $diarista->setTable("users");
        $diarista->exists = true;

        return $diarista->enderecoDiarista()->first();
    }
}
