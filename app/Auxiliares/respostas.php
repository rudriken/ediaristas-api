<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

if (!function_exists("resposta_padrão")) {

    /**
     * Retorna uma resposta padronizada para a API
     *
     * @param int $HTTP
     * @param string $código
     * @param string $mensagem
     * @param array $adicionais
     * @return JsonResponse
     */
    function resposta_padrão(
        int $HTTP,
        string $código,
        string $mensagem,
        array $adicionais = []
    ): JsonResponse {
        return response()->json([
            "HTTP" => $HTTP,
            "código" => $código,
            "mensagem" => $mensagem
        ] + $adicionais, $HTTP);
    }
}

if (!function_exists("resposta_token")) {
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
