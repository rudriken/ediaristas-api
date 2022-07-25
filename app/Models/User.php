<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
    ];

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
				function($pesquisaPeloCódigoIBGE) use ($cIBGE) {
					$pesquisaPeloCódigoIBGE->where("codigo_ibge", $cIBGE);
					// aqui já estamos dentro da tabela "cidades"
				}
			);
	}

	/**
	 * Busca 6 diaristas por código do IBGE
	 * 
	 * @param integer $códigoIBGE
	 * @return Collection
	 */
	static public function diaristasDisponívelCidade(int $códigoIBGE): Collection
	{
		return User::diaristasAtendeCidade($códigoIBGE)->limit(6)->get();
	}

	/**
	 * Retorna a quantidade de diaristas por código do IBGE
	 * 
	 * @param integer $códigoIBGE
	 * @return integer
	 */
	static public function diaristasDisponívelCidadeQuantidade(int $códigoIBGE): int
	{
		return User::diaristasAtendeCidade($códigoIBGE)->count();
	}
}
