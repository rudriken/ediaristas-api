<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Resources\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Actions\Usuario\CriarUsuario;
use App\Actions\Usuario\AtualizarUsuario;
use App\Http\Requests\UsuarioCadastroRequest;
use App\Http\Requests\UsuarioAlteracaoRequest;

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
     * Cria um usuário no sistema
     *
     * @param UsuarioCadastroRequest $request
     * @return Usuario
     */
    public function store(UsuarioCadastroRequest $request): Usuario
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
     * Atualiza os dados do usuário
     *
     * @param UsuarioAlteracaoRequest $requisicao
     * @return JsonResponse
     */
    public function update(UsuarioAlteracaoRequest $requisicao): JsonResponse
    {
        $this->atualizarUsuario->executar($requisicao->except("password_confirmation"));
        return resposta_padrao(200, "sucesso", "Usuário atualizado com sucesso");
    }
}
