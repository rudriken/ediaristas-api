<?php

namespace App\Rules;

use App\Models\Servico;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class TempoAtendimentoDiaria implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private Request $requisição)
    {
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
        $serviço = Servico::find($this->requisição->servico);
        if (!$serviço) {
            return false;
        }
        $total = 0;
        $total += $this->requisição->quantidade_quartos     * $serviço->horas_quarto;
        $total += $this->requisição->quantidade_salas       * $serviço->horas_sala;
        $total += $this->requisição->quantidade_cozinhas    * $serviço->horas_cozinha;
        $total += $this->requisição->quantidade_banheiros   * $serviço->horas_banheiro;
        $total += $this->requisição->quantidade_quintais    * $serviço->horas_quintal;
        $total += $this->requisição->quantidade_outros      * $serviço->horas_outros;
        return $total === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "O tempo de atendimento informado para a diária está incorreto para o tipo de serviço";
    }
}
