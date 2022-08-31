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
    public function __construct(private Request $requisição) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $totalCômodos = 0;
        $totalCômodos += $this->requisição->quantidade_quartos;
        $totalCômodos += $this->requisição->quantidade_salas;
        $totalCômodos += $this->requisição->quantidade_cozinhas;
        $totalCômodos += $this->requisição->quantidade_banheiros;
        $totalCômodos += $this->requisição->quantidade_quintais;
        $totalCômodos += $this->requisição->quantidade_outros;
        return $totalCômodos > 0;
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
