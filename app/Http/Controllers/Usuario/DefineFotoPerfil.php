<?php

namespace App\Http\Controllers\Usuario;

use App\Actions\Usuario\DefinirFotoPerfil;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefineFotoPerfil extends Controller
{
    public function __construct(private DefinirFotoPerfil $definirFotoPerfil)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate(["foto_usuario" => ["required", "image"]]);
        $this->definirFotoPerfil->executar($request->foto_usuario);
        return resposta_padrao(200, "sucesso", "Foto do usuário definida com sucesso");
    }
}
