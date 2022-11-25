<?php

namespace App\Verificadores\Diaria;

use App\Models\Diaria;
use Illuminate\Validation\ValidationException;

class ValidaStatusDiaria
{

    /**
     * Verifica o status de uma diária
     *
     * @param Diaria $diaria
     * @param integer $status
     * @return void
     */
    public function executar(Diaria $diaria, int|array $status): void
    {
        if ($this->statusInvalido($diaria, $status)) {
            $mensagemValidacao = "Só é possível executar essa ação com diárias com status ";
            $mensagemValidacao .= $this->statusValidos($status);
            throw ValidationException::withMessages([
                "status-diaria" => $mensagemValidacao,
            ]);
        }
    }

    /**
     * Indica se o status da diária é inválido
     *
     * @param Diaria $diaria
     * @param integer|array $status
     * @return boolean
     */
    private function statusInvalido(Diaria $diaria, int|array $status): bool
    {
        if (is_int($status)) {
            return $diaria->status !== $status;
        }
        return !in_array($diaria->status, $status);
    }

    /**
     * Formata os status válidos
     *
     * @param integer|array $status
     * @return string
     */
    private function statusValidos(int|array $status): string
    {
        if (is_int($status)) {
            return $status;
        }
        return implode(", ", $status);
    }
}
