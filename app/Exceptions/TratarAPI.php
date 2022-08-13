<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

trait TratarAPI
{

    /**
     * Trata as exceções da nossa API
     *
     * @param \Throwable $erro
     * @return JsonResponse
     */
    protected function pegarExceçãoJSON(\Throwable $erro): JsonResponse
    {
        if ($erro instanceof ValidationException) {
            return $this->erroDeValidação($erro);
        }

        if ($erro instanceof AuthenticationException) {
            return $this->erroDeAutenticação($erro);
        }

        if ($erro instanceof TokenBlacklistedException) {
            return $this->erroDeAutenticação($erro);
        }

        return $this->erroGenérico($erro);
    }

    /**
     * Retorna uma resposta para erro de validação
     *
     * @param ValidationException $erro
     * @return JsonResponse
     */
    protected function erroDeValidação(ValidationException $erro): JsonResponse
    {
        return resposta_padrão(
            400,
            "validação_erro",
            "Erro de validação dos dados enviados",
            $erro->errors()
        );
    }

    /**
     * Retorna uma resposta para erro de autenticação
     *
     * @param AuthenticationException $erro
     * @return JsonResponse
     */
    protected function erroDeAutenticação(
        AuthenticationException|TokenBlacklistedException $erro
    ): JsonResponse {
        return resposta_padrão(401, "token_não_validado", $erro->getMessage());
    }

    /**
     * Retorna uma resposta para erro genérico
     *
     * @param \Throwable $erro
     * @return JsonResponse
     */
    protected function erroGenérico(\Throwable $erro): JsonResponse
    {
        return resposta_padrão(500, "interno_erro", "erro interno do servidor");
    }
}
