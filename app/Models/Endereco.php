<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endereco extends Model
{
    use HasFactory;

    /**
     * Define os campos liberados para definição de dados em massa
     */
    protected $fillable = [
        "logradouro",
        "numero",
        "complemento",
        "bairro",
        "cidade",
        "estado",
        "cep",
        "user_id",
    ];

    /**
     * Define os campos que serão serializados, ou visíveis na resposta
     */
    protected $visible = [
        "logradouro",
        "numero",
        "complemento",
        "bairro",
        "cidade",
        "estado",
        "cep",
    ];
}
