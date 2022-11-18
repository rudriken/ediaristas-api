<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avaliacao extends Model
{
    use HasFactory;

    /**
     * Define o nome da tabela no banco de dados
     *
     * @var string
     */
    protected $table = "avaliacoes";

    /**
     * Define os campos liberados para definição de dados em massa
     *
     * @var array
     */
    protected $fillable = [
        "visibilidade", "nota", "descricao", "diaria_id", "avaliador_id", "avaliado_id",
    ];

    /**
     * Define a relação com o usuário avaliador
     *
     * @return BelongsTo
     */
    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, "avaliador_id");
    }
}
