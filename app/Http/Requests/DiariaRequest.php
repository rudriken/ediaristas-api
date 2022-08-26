<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiariaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "data_atendimento"      => ["required"],
            "tempo_atendimento"     => ["required", "int", "max:8"],
            "preco"                 => ["required"],
            "logradouro"            => ["required"],
            "numero"                => ["required"],
            "complemento"           => ["nullable"],
            "bairro"                => ["required"],
            "cidade"                => ["required"],
            "estado"                => ["required"],
            "codigo_ibge"           => ["required", "int"],
            "cep"                   => ["required"],
            "quantidade_quartos"    => ["required", "int"],
            "quantidade_salas"      => ["required", "int"],
            "quantidade_cozinhas"   => ["required", "int"],
            "quantidade_banheiros"  => ["required", "int"],
            "quantidade_quintais"   => ["required", "int"],
            "quantidade_outros"     => ["required", "int"],
            "servico"               => ["required", "exists:servicos,id"],
        ];
    }
}
