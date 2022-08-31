<?php

namespace App\Rules;

use App\Models\Servico;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class PrecoDiaria implements Rule
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
    public function passes($attribute, $value): bool
    {
        $serviço = Servico::find($this->requisição->servico);
        if (!$serviço) {
            return false;
        }
        $total = 0;
        $total += $this->requisição->quantidade_quartos     * $serviço->valor_quarto;
        $total += $this->requisição->quantidade_salas       * $serviço->valor_sala;
        $total += $this->requisição->quantidade_cozinhas    * $serviço->valor_cozinha;
        $total += $this->requisição->quantidade_banheiros   * $serviço->valor_banheiro;
        $total += $this->requisição->quantidade_quintais    * $serviço->valor_quintal;
        $total += $this->requisição->quantidade_outros      * $serviço->valor_outros;
        if ($value < $serviço->valor_minimo) {
            return false;
        } else if ($value == $serviço->valor_minimo && $total < $serviço->valor_minimo) {
            return true;
        } else {
            return $total === (float) $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O preço informado para a diária está incorreto para o tipo de serviço.';
    }
}
