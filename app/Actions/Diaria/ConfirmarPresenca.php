<?php

namespace App\Actions\Diaria;

use Carbon\Carbon;
use App\Models\Diaria;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use App\Verificadores\Diaria\ValidaStatusDiaria;

class ConfirmarPresenca
{

    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    /**
     * Confirma a presença do(a) diarista no local de atendimento na data correta
     *
     * @param Diaria $diaria
     * @return boolean
     */
    public function executar(Diaria $diaria): bool
    {
        Gate::authorize("tipo-cliente");
        Gate::authorize("dono-diaria", $diaria);
        $this->validaStatusDiaria->executar($diaria, 3);
        $this->validaDataAtendimento($diaria);
        $diaria->status = 4;
        return $diaria->save();
    }

    /**
     * Valida se a data atual é menor que a data de atendimento
     *
     * @param Diaria $diaria
     * @return void
     */
    private function validaDataAtendimento(Diaria $diaria): void
    {
        $dataAtendimento = Carbon::parse($diaria->data_atendimento);
        $agora = Carbon::now();
        if ($agora < $dataAtendimento) {
            throw ValidationException::withMessages([
                "data_atendimento" =>
                "Só é possível confirmar a presença após a data de atendimento"
            ]);
        }
    }
}
