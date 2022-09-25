<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use App\Http\Hateoas\Usuario as HateoasUsuario;
use Illuminate\Http\Resources\Json\JsonResource;

class Usuario extends JsonResource
{
    private string $token;

    public function __construct($recurso, $simbolo = "")
    {
        $this->token = $simbolo;
        parent::__construct($recurso); /* passando para a classe-mãe os dados do usuário */
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        $formato = [
            "id"                => $this->id,
            "nome_completo"     => $this->nome_completo,
            "cpf"               => $this->cpf,
            "nascimento"        => $this->nascimento,
            "email"             => $this->email,
            "telefone"          => $this->telefone,
            "reputacao"         => $this->reputacao,
            "tipo_usuario"      => $this->tipo_usuario,
            "foto_usuario"      => $this->foto_usuario,
            "chave_pix"         => null,
            "links"             => (new HateoasUsuario)->links($this->resource),
        ];
        if ($this->token !== "") {
            return $formato + [
                "token"             => [
                    "acesso"            => $this->token,
                    "refresh"           => $this->token,
                    "token_tipo"        => "bearer",
                    "expira_em"         => Auth::factory()->getTTL() * 60,
                ]
            ];
        }
        return $formato;
    }
}
