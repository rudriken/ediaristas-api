<?php

namespace App\Rules;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class HoraFinalDiaria implements Rule
{
    private Request $requisição;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->requisição = $request;
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
        $inícioAtendimento = CarbonImmutable::parse($this->requisição->data_atendimento);
        $finalAtendimento = $inícioAtendimento->addHours($value);
        $limiteHorárioParaAtendimento = $inícioAtendimento->setHour(22)->setMinute(0);
        return $finalAtendimento <= $limiteHorárioParaAtendimento;
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
