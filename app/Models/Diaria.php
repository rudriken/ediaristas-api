<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diaria extends Model
{
    use HasFactory;

    /**
     * Campos bloqueados na definição de dados em massa
     */
    protected $guarded = ["motivo_cancelamento", "created_at", "updated_at"];

    /**
     * Define a relação com serviço
     *
     * @return BelongsTo
     */
    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class);
    }

    /**
     * Define a relação com cliente
     *
     * @return BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, "cliente_id");
    }

    /**
     * Define a relação com os candidatos a realizar a diária
     *
     * @return HasMany
     */
    public function candidatos(): HasMany
    {
        return $this->hasMany(CandidatosDiaria::class);
    }

    /**
     * Define o status da diária como pago
     *
     * @return boolean
     */
    public function pagar(): bool
    {
        $this->status = 2;
        return $this->save();
    }

    /**
     * Retorna as diárias do usuário
     *
     * @param User $usuario
     * @return Collection
     */
    static function todasDoUsuario(User $usuario): Collection
    {
        return self::when(
            $usuario->tipo_usuario === 1,
            function ($consulta) use ($usuario) {
                $consulta->where("cliente_id", $usuario->id);
            }
        )->when(
            $usuario->tipo_usuario === 2,
            function ($consulta) use ($usuario) {
                $consulta->where("diarista_id", $usuario->id);
            }
        )->get();
    }

    /**
     * Define um(a) candidato(a) para a diária
     *
     * @param integer $diaristaId
     * @return Illuminate\Database\Eloquent\Model
     */
    public function defineCandidato(int $diaristaId): Model
    {
        return $this->candidatos()->create(["diarista_id" => $diaristaId]);
    }

    /**
     * Define o(a) diarista para realizar a diária e muda o status da mesma para
     *
     * @param integer $diaristaId
     * @return boolean
     */
    public function confirmarDiaria(int $diaristaId): bool
    {
        $this->diarista_id = $diaristaId;
        $this->status = 3;
        return $this->save();
    }
}
