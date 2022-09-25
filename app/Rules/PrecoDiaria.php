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
    public function __construct(private Request $requisicao)
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
        $servico = Servico::find($this->requisicao->servico);
        if (!$servico) {
            return false;
        }
        $total = 0;
        $total += $this->requisicao->quantidade_quartos     * $servico->valor_quarto;
        $total += $this->requisicao->quantidade_salas       * $servico->valor_sala;
        $total += $this->requisicao->quantidade_cozinhas    * $servico->valor_cozinha;
        $total += $this->requisicao->quantidade_banheiros   * $servico->valor_banheiro;
        $total += $this->requisicao->quantidade_quintais    * $servico->valor_quintal;
        $total += $this->requisicao->quantidade_outros      * $servico->valor_outros;
        if ($value < $servico->valor_minimo) {
            return false;
        } else if ($value == $servico->valor_minimo && $total < $servico->valor_minimo) {
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
