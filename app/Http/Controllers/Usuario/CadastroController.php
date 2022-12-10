<?php

namespace App\Http\Controllers\Usuario;

use App\Actions\Usuario\AtualizarUsuario;
use Illuminate\Http\Request;
use App\Http\Resources\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Usuario\CriarUsuario;
use App\Http\Requests\UsuarioCadastroRequest;

class CadastroController extends Controller
{
    private CriarUsuario $criarUsuario;
    private AtualizarUsuario $atualizarUsuario;

    public function __construct(CriarUsuario $acao, AtualizarUsuario $acao2)
    {
        $this->criarUsuario = $acao;
        $this->atualizarUsuario = $acao2;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioCadastroRequest $request)
    {
        $usuario = $this->criarUsuario->executar(
            $request->except("password_confirmation"),
            $request->foto_documento
        );
        $token = Auth::attempt([
            "email" => $usuario->email,
            "password" => $request->password,
        ]);
        return new Usuario($usuario, $token);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->atualizarUsuario->executar();
    }
}
