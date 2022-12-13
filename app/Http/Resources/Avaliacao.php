<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Avaliacao extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "descricao" => $this->descricao,
            "nota" => $this->nota,
            "nome_avaliador" => $this->avaliador->nome_completo,
            "foto_avaliador" => foto_perfil($this->avaliador->foto_usuario),
        ];
    }
}
