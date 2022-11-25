<?php

namespace App\Actions\Diaria\Cancelamento;

use App\Models\Diaria;
use App\Verificadores\Diaria\ValidaStatusDiaria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CancelarDiaria
{
    public function __construct(private ValidaStatusDiaria $validaStatusDiaria)
    {
    }

    public function executar(Diaria $diaria)
    {
        $this->validaStatusDiaria->executar($diaria, [2, 3]);
        $this->verificaDataAtendimento($diaria->data_atendimento);
        Gate::authorize("dono-diaria", $diaria);
        dd("diária cancelada com sucesso!");
    }

    private function verificaDataAtendimento(string $dataAtendimento)
    {
        $dataAtendimento = new Carbon($dataAtendimento);
        $agora = Carbon::now();

        if ($agora > $dataAtendimento) {
            throw ValidationException::withMessages([
                "data_atendimento" => "Não é mais possível cancelar essa diária. " .
                    "Entre em contato com o nosso suporte!",
            ]);
        }
    }
}
