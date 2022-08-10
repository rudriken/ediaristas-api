<?php

namespace App\Http\Requests;

use App\Rules\IdadeMinima;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioCadastroRequest extends FormRequest
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
    public function rules(): array
    {
        $regras = [
            "nome_completo"         => ["required", "min:5", "max:255"],
            "cpf"                   => ["required", "unique:users,cpf", "cpf"],
            "nascimento"            => ["required", "date", new IdadeMinima],
            "foto_documento"        => ["required", "image"],
            "telefone"              => ["required", "size:11"],
            "tipo_usuario"          => ["required", Rule::in([1, 2])],
            "email"                 => ["required", "email", "unique:users,email"],
            "password"              => ["required", "confirmed"],
            "password_confirmation" => ["required"],
        ];
        $regraPIX = [];
        if ($this->tipo_usuario == 2) {
            $regraPIX = ["chave_pix" => ["required", "min:4", "string"]];
        }
        return $regras + $regraPIX;
    }
}
