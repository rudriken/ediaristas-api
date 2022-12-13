<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioSimplificado extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id"            => $this->id,
            "nome_completo" => $this->nome_completo,
            "nascimento"    => $this->nascimento,
            "telefone"      => $this->telefone,
            "reputacao"     => $this->reputacao,
            "tipo_usuario"  => $this->tipo_usuario,
            "foto_usuario"  => foto_perfil($this->foto_usuario),
        ];
    }
}
