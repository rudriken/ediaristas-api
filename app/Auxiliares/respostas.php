<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

if (!function_exists("resposta_padrao")) {

    /**
     * Retorna uma resposta padronizada para a API
     *
     * @param int $HTTP
     * @param string $codigo
     * @param string $mensagem
     * @param array $adicionais
     * @return JsonResponse
     */
    function resposta_padrao(
        int $HTTP,
        string $codigo,
        string $mensagem,
        array $adicionais = []
    ): JsonResponse {
        return response()->json([
            "HTTP" => $HTTP,
            "codigo" => $codigo,
            "mensagem" => $mensagem
        ] + $adicionais, $HTTP);
    }
}

if (!function_exists("resposta_token")) {

    /**
     * Retorna uma resposta padrão para os tokens de autenticação
     *
     * @param string $token
     * @return JsonResponse
     */
    function resposta_token(string $token): JsonResponse
    {
        return response()->json([
            "acesso" => $token,
            "refresh" => $token,
            "token_tipo" => "bearer",
            "expira_em" => Auth::factory()->getTTL() * 60,
        ]);
    }
}
