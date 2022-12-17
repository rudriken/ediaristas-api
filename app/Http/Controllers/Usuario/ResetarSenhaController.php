<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetarSenhaController extends Controller
{
    public function solicitarToken(Request $requisicao)
    {
        $requisicao->validate(["email" => ["required", "email"]]);
        Password::sendResetLink($requisicao->only("email"));
        return resposta_padrao(
            200,
            "sucesso",
            "Verifique na sua caixa de entrada ou de span a mensagem"
        );
    }
}
