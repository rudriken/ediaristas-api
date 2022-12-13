<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiaristaPublico extends JsonResource
{
    /**
     * Define os dados retornados para cada diarista
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "nome" => $this->nome_completo,
            "reputacao" => $this->reputacao,
            "foto_do_usuario" => foto_perfil($this->foto_usuario),
            "cidade" => "Uberlândia"
        ];
    }
}
