<?php

namespace App\Http\Controllers\Usuário;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutenticacaoController extends Controller
{
    public function login(Request $requisição)
    {
        $credenciais = $requisição->only(["email", "password"]);
        if (!$token = Auth::attempt($credenciais)) {
            return response()->json(["erro" => "Não autorizado"], 401);
        }
        return response()->json([
            "acesso" => $token,
        ]);
    }

    public function eu()
    {
        return Auth::user();
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
        return response()->json([
            "acesso" => Auth::refresh(),
        ]);
    }
}
