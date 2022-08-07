<?php

namespace App\Http\Controllers\Usuários;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Usuário\CriarUsuario;

class CadastroController extends Controller
{
    private CriarUsuario $criarUsuário;

    public function __construct(CriarUsuario $ação)
    {
        $this->criarUsuário = $ação;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuário = $this->criarUsuário->executar(
            $request->except("password_confirmation"),
            $request->foto_documento
        );
        return $usuário;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
