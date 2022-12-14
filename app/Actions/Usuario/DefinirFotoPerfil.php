<?php

namespace App\Actions\Usuario;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class DefinirFotoPerfil
{

    /**
     * Define a foto do perfil do uusário
     *
     * @param UploadedFile $fotoUsuario
     * @return boolean
     */
    public function executar(UploadedFile $fotoUsuario): bool
    {
        $login = Auth::user();

        $usuario = new User;

        $usuario->id = $login->id;
        $usuario->nome_completo = $login->nome_completo;
        $usuario->cpf = $login->cpf;
        $usuario->nascimento = $login->nascimento;
        $usuario->foto_documento = $login->foto_documento;
        $usuario->foto_usuario = $login->foto_usuario;
        $usuario->telefone = $login->telefone;
        $usuario->tipo_usuario = $login->tipo_usuario;
        $usuario->chave_pix = $login->chave_pix;
        $usuario->reputacao = $login->reputacao;
        $usuario->email = $login->email;
        // $usuario->email_verified_at = $login->email_verified_at;
        $usuario->password = $login->password;
        // $usuario->remember_token = $login->remember_token;
        $usuario->created_at = $login->created_at;
        // $usuario->updated_at = $login->updated_at;
        $usuario->setConnection("mysql");
        $usuario->setTable("users");
        $usuario->exists = true;

        $usuario->foto_usuario = $fotoUsuario->store("public");
        return $usuario->update();
    }
}
