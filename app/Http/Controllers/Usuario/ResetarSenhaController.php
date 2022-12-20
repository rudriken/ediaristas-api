<?php

namespace App\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

class ResetarSenhaController extends Controller
{

    /**
     * Envia o e-mail com o link de reset de senha
     *
     * @param Request $requisicao
     * @return JsonResponse
     */
    public function solicitarToken(Request $requisicao): JsonResponse
    {
        $requisicao->validate(["email" => ["required", "email"]]);
        Password::sendResetLink($requisicao->only("email"));
        return resposta_padrao(
            200,
            "sucesso",
            "Verifique na sua caixa de entrada ou de span a mensagem"
        );
    }

    /**
     * Reseta a senha do usuário no banco de dados
     *
     * @param Request $requisicao
     * @return JsonResponse
     */
    public function resetarSenha(Request $requisicao): JsonResponse
    {
        $requisicao->validate([
            "email"                 => ["required", "email"],
            "password"              => ["required", "min:8", "confirmed"],
            "password_confirmation" => ["required"],
            "token"                 => ["required"],
        ]);

        $status = Password::reset(
            $requisicao->only("email", "password", "token"),
            function ($usuario, $senha) {
                $usuario->forceFill(["password" => Hash::make($senha)]);
                $usuario->save();
                event(new PasswordReset($usuario));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                "status_reset" => "Não foi possível alterar a senha",
            ]);
        }

        return resposta_padrao(200, "sucesso", "Senha alterada com sucesso!");
    }
}
