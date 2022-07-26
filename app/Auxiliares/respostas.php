<?php

use Illuminate\Http\JsonResponse;

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
		int $HTTP, string $código, string $mensagem, array $adicionais=[]
	): JsonResponse {
		return response()->json([
			"HTTP" => $HTTP,
			"código" => $código,
			"mensagem" => $mensagem
		] + $adicionais, $HTTP);
	}
}
