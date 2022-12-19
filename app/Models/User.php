<?php

namespace App\Models;

use App\Notifications\ResetarSenhaNotification;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_completo',
        'cpf',
        'nascimento',
        'foto_documento',
        'telefone',
        'tipo_usuario',
        'chave_pix',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        "tipo_usuario" => "int",
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Define a relação com as cidades atendidas pelo(a) diarista
     *
     * @return BelongsToMany
     */
    public function cidadesAtendidas(): BelongsToMany
    {
        return $this->belongsToMany(Cidade::class, "cidade_diarista");
        // um diarista atende a "n" cidades
    }

    /**
     * Escopo que filtra os(as) diaristas
     *
     * @param Builder $consulta
     * @return Builder
     */
    public function scopeTipoDiarista(Builder $consulta): Builder
    {
        return $consulta->where("tipo_usuario", 2);
    }

    /**
     * Escopo que filtra diaristas por código do IBGE
     *
     * @param Builder $consulta
     * @param integer $cIBGE
     * @return Builder
     */
    public function scopeDiaristasAtendeCidade(Builder $consulta, int $cIBGE): Builder
    {
        return $consulta->tipoDiarista()
            ->whereHas(
                "cidadesAtendidas", // aqui entramos na tabela "cidades"
                function ($pesquisaPeloCodigoIBGE) use ($cIBGE) {
                    $pesquisaPeloCodigoIBGE->where("codigo_ibge", $cIBGE);
                    // aqui já estamos dentro da tabela "cidades"
                }
            );
    }

    /**
     * Busca 6 diaristas por código do IBGE
     *
     * @param integer $codigoIBGE
     * @return Collection
     */
    static public function diaristasDisponivelCidade(int $codigoIBGE): Collection
    {
        return User::diaristasAtendeCidade($codigoIBGE)->limit(6)->get();
    }

    /**
     * Retorna a quantidade de diaristas por código do IBGE
     *
     * @param integer $codigoIBGE
     * @return integer
     */
    static public function diaristasDisponivelCidadeQuantidade(int $codigoIBGE): int
    {
        return User::diaristasAtendeCidade($codigoIBGE)->count();
    }

    /**
     * Retorna as cidades atendidas pelo(a) diarista
     *
     * @return array
     */
    public function cidadesAtendidasDiarista(): array
    {
        return $this->cidadesAtendidas()->pluck("codigo_ibge")->toArray();
    }

    /**
     * Define a relação do(a) diarista com o seu endereço
     *
     * @return HasOne
     */
    public function enderecoDiarista(): HasOne
    {
        return $this->hasOne(Endereco::class, "user_id");
    }

    /**
     * Define a relação do(a) usuário com suas avaliações recebidas
     *
     * @return HasMany
     */
    public function avaliado(): HasMany
    {
        return $this->hasMany(Avaliacao::class, "avaliado_id");
    }

    public function sendPasswordResetNotification($token)
    {
        $url = "http://localhost:3000/recuperar-senha?token=" . $token;
        $this->notify(new ResetarSenhaNotification($url));
    }
}
