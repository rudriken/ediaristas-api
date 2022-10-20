<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidatosDiaria extends Model
{
    use HasFactory;

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