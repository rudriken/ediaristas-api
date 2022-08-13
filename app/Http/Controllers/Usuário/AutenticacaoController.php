<?php

namespace App\Http\Controllers\Usuário;

use Illuminate\Http\Request;
use App\Http\Resources\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AutenticacaoController extends Controller
{
    public function login(Request $requisição)
    {
        $credenciais = $requisição->only(["email", "password"]);
        if (!$token = Auth::attempt($credenciais)) {
            return response()->json(["erro" => "Não autorizado"], 401);
        }
        return resposta_token($token);
    }

    public function eu()
    {
        return new Usuario(Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            "mensagem" => "Logout com sucesso",
        ]);
    }

    public function atualizar()
    {
        return resposta_token(Auth::refresh());
    }
}
