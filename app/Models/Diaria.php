<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
     * Define a relação com diarista
     *
     * @return BelongsTo
     */
    public function diarista(): BelongsTo
    {
        return $this->belongsTo(User::class, "diarista_id");
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
     * Define a relação com as avaliações do(a) cliente e diarista
     *
     * @return HasMany
     */
    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    /**
     * Define a relação de uma diária com os pagamentos
     *
     * @return HasMany
     */
    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class);
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
     * Define o(a) diarista para realizar a diária e muda o status da mesma para 2
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

    /**
     * Retorna a lista de oportunidades para o(a) diarista conforme sua região
     *
     * @param User $diarista
     * @return Collection
     */
    static public function oportunidadesPorCidade(User $diarista): Collection
    {
        $cidadesAtendidasPeloDiarista = $diarista->cidadesAtendidasDiarista();
        return self
            ::where("status", 2)
            ->whereIn("codigo_ibge", $cidadesAtendidasPeloDiarista)
            ->has("candidatos", "<", 3)
            ->whereDoesntHave(
                "candidatos",
                function (Builder $consulta) use ($diarista) {
                    $consulta->where("diarista_id", $diarista->id);
                }
            )
            ->get();
    }

    /**
     * Retorna todas as diárias pagas com mais de 24 horas de criadas
     *
     * @return Collection<Diaria>
     */
    static public function pagasComMaisDe24Horas(): Collection
    {
        return self::where("status", 2)
            ->where("created_at", "<", Carbon::now()->subHours(24))
            ->with("candidatos", "candidatos.candidato.enderecoDiarista")
            ->withCount("candidatos")
            ->get();
    }

    /**
     * Verifica se o usuário logado já avaliou determinada diária
     *
     * @param integer $usuarioId
     * @return boolean
     */
    public function verificaDuplicidadeDeAvaliacao(int $usuarioId): bool
    {
        return !!$this->avaliacoes()->where("avaliador_id", $usuarioId)->first();
    }

    /**
     * Retorna as diárias com menos de 24 horas para atendimento e sem diarista definido(a)
     *
     * @return Collection<self>
     */
    static public function comMenosDe24HorasParaAtendimentoSemDiarista(): Collection
    {
        return self::where("status", "2")
            ->whereDate("data_atendimento", "<", Carbon::now()->addHours(24)->toISOString())
            ->get();
    }

    /**
     * Define o status "cancelado" para uma diária
     *
     * @return void
     */
    public function cancelar(string $motivoCancelamento = null): void
    {
        $this->status = 5;
        $this->motivo_cancelamento = $motivoCancelamento;
        $this->save();
    }

    /**
     * Retorna o primeiro pagamento válido para a diária
     *
     * @return Pagamento
     */
    public function pagamentoValido(): Pagamento
    {
        return $this->pagamentos()->where("status", "pago")->first();
    }

    /**
     * Retorna a lista de diárias como pagamento do(a) diarista
     *
     * @param User $diarista
     * @return Collection
     */
    static public function pagamentosDiarista(User $diarista): Collection
    {
        return self::where("diarista_id", $diarista->id)
            ->whereIn("status", [4, 6, 7])
            ->get();
    }
}
