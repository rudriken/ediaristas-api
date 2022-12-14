<?php

namespace App\Http\Requests;

use App\Rules\IdadeMinima;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioAlteracaoRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $usuarioLogado = Auth::user();
        $regras = [
            "nome_completo"         => ["required", "min:5", "max:255"],
            "cpf"                   => [
                "required", "unique:users,cpf," . $usuarioLogado->id, "cpf"
            ],
            "nascimento"            => ["required", "date", new IdadeMinima],
            "telefone"              => ["required", "size:11"],
            "email"                 => [
                "required", "email", "unique:users,email," . $usuarioLogado->id
            ],
        ];

        if ($this->has("new_password")) {
            $regras = $regras + [
                "new_password"          => ["required"],
                "password_confirmation" => ["required", "same:new_password"],
            ];
        }

        return $regras;
    }
}
