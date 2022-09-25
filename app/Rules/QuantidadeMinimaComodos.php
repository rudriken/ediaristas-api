<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class QuantidadeMinimaComodos implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private Request $requisicao) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $totalComodos = 0;
        $totalComodos += $this->requisicao->quantidade_quartos;
        $totalComodos += $this->requisicao->quantidade_salas;
        $totalComodos += $this->requisicao->quantidade_cozinhas;
        $totalComodos += $this->requisicao->quantidade_banheiros;
        $totalComodos += $this->requisicao->quantidade_quintais;
        $totalComodos += $this->requisicao->quantidade_outros;
        return $totalComodos > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A diária deve ter, ao menos, 1 cômodo selecionado';
    }
}
