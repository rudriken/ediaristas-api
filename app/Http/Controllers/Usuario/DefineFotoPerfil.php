<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\Usuario\DefinirFotoPerfil;

class DefineFotoPerfil extends Controller
{
    public function __construct(private DefinirFotoPerfil $definirFotoPerfil)
    {
    }

    /**
     * Define a foto do usuário
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate(["foto_usuario" => ["required", "image"]]);
        $this->definirFotoPerfil->executar($request->foto_usuario);
        return resposta_padrao(200, "sucesso", "Foto do usuário definida com sucesso");
    }
}
