<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class PagarDiaria
{
    public function executar(Diaria $diaria)
    {
        $this->validaStatusDiaria($diaria);
        Gate::authorize("tipo-cliente");
        // integração com o gateway de pagamento
        $diaria->pagar();
    }

    /**
     * Valida se o status da diária é igual a 1
     *
     * @param Diaria $diaria
     * @return void
     */
    private function validaStatusDiaria(Diaria $diaria): void
    {
        if ($diaria->status !== 1) {
            throw ValidationException::withMessages([
                "status" => "Só é possível executar essa ação com diárias com status 1"
            ]);
        }
    }
}
