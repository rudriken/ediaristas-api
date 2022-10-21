<?php

namespace App\Actions\Diaria;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Illuminate\Support\Facades\Gate;

class PagarDiaria
{

    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    /**
     * Executa o pagamento da diária
     *
     * @param Diaria $diaria
     * @param string $cardHash
     * @return boolean
     */
    public function executar(Diaria $diaria, string $cardHash): bool
    {
        $this->validaStatusDiaria->executar($diaria, 1);
        Gate::authorize("tipo-cliente");
        Gate::authorize("dono-diaria", $diaria);
        // integração com o gateway de pagamento
        return $diaria->pagar();
    }
}
