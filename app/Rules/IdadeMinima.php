<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IdadeMinima implements Rule
{
    private int $idade;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $hoje = new \DateTime;
        $quantidadeAnos = $hoje->diff(new \DateTime($value))->y;
        $this->idade = $quantidadeAnos;
        return $quantidadeAnos >= 18;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "É necessário ter pelo menos 18 anos para se cadastrar na plataforma. Sua idade é $this->idade anos!";
    }
}
