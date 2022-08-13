<?php

namespace App\Http\Controllers\Usuário;

use Illuminate\Http\Request;
use App\Http\Resources\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Usuário\CriarUsuario;
use App\Http\Requests\UsuarioCadastroRequest;

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
    public function store(UsuarioCadastroRequest $request)
    {
        $usuário = $this->criarUsuário->executar(
            $request->except("password_confirmation"),
            $request->foto_documento
        );
        $token = Auth::attempt([
            "email" => $usuário->email,
            "password" => $request->password,
        ]);
        return new Usuario($usuário, $token);
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
