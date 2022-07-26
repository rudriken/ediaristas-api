<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use \Illuminate\Http\JsonResponse;

trait TratarAPI {

	/**
	 * Trata as exceções da nossa API 
	 * 
	 * @param \Throwable $erro
	 * @return JsonResponse
	 */
	protected function pegarExceçãoJSON(\Throwable $erro): JsonResponse {
		if ($erro instanceof ValidationException) {
			return $this->erroDeValidação($erro);
		}

		return $this->erroGenérico($erro);
	}

	/**
	 * Retorna uma resposta para erro de validação
	 * 
	 * @param ValidationException $erro
	 * @return JsonResponse
	 */
	protected function erroDeValidação(ValidationException $erro): JsonResponse {
		return resposta_padrão(
			400, "validação_erro", "Erro de validação dos dados enviados", $erro->errors()
		);
	}

	/**
	 * Retorna uma resposta para erro genérico
	 * 
	 * @param \Throwable $erro
	 * @return JsonResponse
	 */
	protected function erroGenérico(\Throwable $erro): JsonResponse {
		return resposta_padrão(500, "interno_erro", "erro interno do servidor");
	}
}