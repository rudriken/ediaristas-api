<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pagamento extends Model
{
    use HasFactory;

    /**
     * Define os campos liberados para definição de dados em massa
     *
     * @var array
     */
    protected $fillable = ["status", "valor", "transacao_id"];
}
