<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait TratarAPI
{

    /**
     * Trata as exceções da nossa API
     *
     * @param \Throwable $erro
     * @return JsonResponse
     */
    protected function pegarExcecaoJSON(\Throwable $erro): JsonResponse
    {
        if ($erro instanceof ValidationException) {
            return $this->erroDeValidacao($erro);
        }

        if ($erro instanceof AuthenticationException) {
            return $this->erroDeAutenticacao($erro);
        }

        if ($erro instanceof TokenBlacklistedException) {
            return $this->erroDeAutenticacao($erro);
        }

        if ($erro instanceof AuthorizationException) {
            return $this->erroDeAutorizacao($erro);
        }

        if ($erro instanceof ModelNotFoundException) {
            return $this->erroDeNaoEncontrado();
        }

        if ($erro instanceof HttpException) {
            return $this->erroDeHTTP($erro);
        }

        return $this->erroGenerico($erro);
    }

    /**
     * Retorna uma resposta para erro de validação
     *
     * @param ValidationException $erro
     * @return JsonResponse
     */
    protected function erroDeValidacao(ValidationException $erro): JsonResponse
    {
        return resposta_padrao(
            400,
            "validacao_erro",
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
    protected function erroDeAutenticacao(
        AuthenticationException|TokenBlacklistedException $erro
    ): JsonResponse {
        return resposta_padrao(401, "token_nao_validado", $erro->getMessage());
    }

    /**
     * Retorna uma resposta para erro de autorização
     *
     * @param AuthorizationException $erro
     * @return JsonResponse
     */
    protected function erroDeAutorizacao(AuthorizationException $erro): JsonResponse
    {
        return resposta_padrao(403, "erro_de_autorizacao", $erro->getMessage());
    }

    /**
     * Retorna uma resposta para erro de Model não encontrado
     *
     * @return JsonResponse
     */
    protected function erroDeNaoEncontrado(): JsonResponse
    {
        return resposta_padrao(404, "erro_de_nao_encontrado", "Recurso não encontrado");
    }

    /**
     * Retorna uma resposta para erro de HTTP
     *
     * @param HttpException $erro
     * @return JsonResponse
     */
    protected function erroDeHTTP(HttpException $erro): JsonResponse
    {
        return resposta_padrao($erro->getStatusCode(), "erro_de_HTTP", $erro->getMessage());
    }

    /**
     * Retorna uma resposta para erro genérico
     *
     * @param \Throwable $erro
     * @return JsonResponse
     */
    protected function erroGenerico(\Throwable $erro): JsonResponse
    {
        return resposta_padrao(500, "interno_erro", "erro interno do servidor");
    }
}
