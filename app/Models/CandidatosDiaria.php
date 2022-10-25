<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidatosDiaria extends Model
{
    use HasFactory;

    /**
     * Define campos permitidos na definição de dados em massa
     *
     * @var array
     */
    protected $fillable = ["diarista_id", "diaria_id"];

    /**
     * Define o nome da tabela que este Model representará
     *
     * @var string
     */
    protected $table = "candidatos_diaria";

    /**
     * Define a relação com o candidato para realizar a diária
     *
     * @return BelongsTo
     */
    public function candidato(): BelongsTo
    {
        return $this->belongsTo(
            User::class,    /* Model da relação */
            "diarista_id"   /* coluna da "candidatos_diaria" que terá o id de "users" */
        );
    }
}
