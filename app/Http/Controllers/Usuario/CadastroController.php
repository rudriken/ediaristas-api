<?php

namespace App\Http\Controllers\Usuario;

use App\Actions\Usuario\AtualizarUsuario;
use App\Http\Resources\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Usuario\CriarUsuario;
use App\Http\Requests\UsuarioAlteracaoRequest;
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

    public function update(UsuarioAlteracaoRequest $requisicao)
    {
        $this->atualizarUsuario->executar($requisicao->except("password_confirmation"));
        return resposta_padrao(200, "sucesso", "Usuário atualizado com sucesso");
    }
}
