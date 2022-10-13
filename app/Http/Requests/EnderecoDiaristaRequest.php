<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoDiaristaRequest extends FormRequest
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
            "logradouro"    => ["required", "min:3", "max:255"],
            "numero"        => ["required"],
            "bairro"        => ["required", "min:3", "max:255"],
            "cidade"        => ["required", "min:3", "max:255"],
            "estado"        => ["required", "size:2"],
            "cep"           => ["required", "size:8"],
        ];
    }
}
