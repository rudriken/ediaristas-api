<?php

namespace App\Rules;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class HoraFinalDiaria implements Rule
{
    private Request $requisicao;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->requisicao = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $inicioAtendimento = CarbonImmutable::parse($this->requisicao->data_atendimento);
        $finalAtendimento = $inicioAtendimento->addHours($value);
        $limiteHorarioParaAtendimento = $inicioAtendimento->setHour(22)->setMinute(0);
        return $finalAtendimento <= $limiteHorarioParaAtendimento;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O horário limite da diária é às 22 horas';
    }
}
