<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use App\Http\Resources\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AutenticacaoController extends Controller
{

    /**
     * Realiza o login a partir do e-mail e senha
     *
     * @param Request $requisicao
     * @return JsonResponse
     */
    public function login(Request $requisicao): JsonResponse
    {
        $credenciais = $requisicao->only(["email", "password"]);
        if (!$token = Auth::attempt($credenciais)) {
            return response()->json(["erro" => "Não autorizado"], 401);
        }
        return resposta_token($token);
    }

    /**
     * Retorna os dados do usuário logado atualmente
     *
     * @return Usuario
     */
    public function eu(): Usuario
    {
        return new Usuario(Auth::user());
    }

    /**
     * Invalida o token passado no Header
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            "mensagem" => "Logout com sucesso",
        ]);
    }

    /**
     * Renova o token enviado no Header
     *
     * @return JsonResponse
     */
    public function atualizar(): JsonResponse
    {
        return resposta_token(Auth::refresh());
    }
}
